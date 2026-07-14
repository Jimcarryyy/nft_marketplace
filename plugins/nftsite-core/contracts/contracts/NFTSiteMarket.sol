// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "@openzeppelin/contracts/token/ERC721/IERC721.sol";
import "@openzeppelin/contracts/utils/ReentrancyGuard.sol";
import "@openzeppelin/contracts/access/Ownable.sol";

/**
 * @title NFTSiteMarket
 * @notice Fixed-price marketplace with platform fee.
 */
contract NFTSiteMarket is ReentrancyGuard, Ownable {
    struct Listing {
        address seller;
        uint256 price;
        bool active;
    }

    uint96 public feeBps;
    address public treasury;

    mapping(address => mapping(uint256 => Listing)) public listings;

    event Listed(address indexed nft, uint256 indexed tokenId, address indexed seller, uint256 price);
    event Sold(address indexed nft, uint256 indexed tokenId, address indexed buyer, uint256 price);
    event Cancelled(address indexed nft, uint256 indexed tokenId, address indexed seller);

    constructor(address initialOwner, address treasury_, uint96 feeBps_) Ownable(initialOwner) {
        require(treasury_ != address(0), "treasury");
        require(feeBps_ <= 1000, "fee too high");
        treasury = treasury_;
        feeBps = feeBps_;
    }

    function setFee(uint96 feeBps_) external onlyOwner {
        require(feeBps_ <= 1000, "fee too high");
        feeBps = feeBps_;
    }

    function setTreasury(address treasury_) external onlyOwner {
        require(treasury_ != address(0), "treasury");
        treasury = treasury_;
    }

    function listItem(address nft, uint256 tokenId, uint256 price) external {
        require(price > 0, "price");
        require(IERC721(nft).ownerOf(tokenId) == msg.sender, "not owner");
        require(
            IERC721(nft).getApproved(tokenId) == address(this) ||
                IERC721(nft).isApprovedForAll(msg.sender, address(this)),
            "not approved"
        );
        listings[nft][tokenId] = Listing({seller: msg.sender, price: price, active: true});
        emit Listed(nft, tokenId, msg.sender, price);
    }

    function cancelListing(address nft, uint256 tokenId) external {
        Listing memory item = listings[nft][tokenId];
        require(item.active, "not listed");
        require(item.seller == msg.sender || msg.sender == owner(), "not seller");
        delete listings[nft][tokenId];
        emit Cancelled(nft, tokenId, item.seller);
    }

    function buyItem(address nft, uint256 tokenId) external payable nonReentrant {
        Listing memory item = listings[nft][tokenId];
        require(item.active, "not listed");
        require(msg.value >= item.price, "payment");

        delete listings[nft][tokenId];

        uint256 fee = (item.price * feeBps) / 10000;
        uint256 sellerProceeds = item.price - fee;

        IERC721(nft).safeTransferFrom(item.seller, msg.sender, tokenId);

        if (fee > 0) {
            (bool okFee, ) = payable(treasury).call{value: fee}("");
            require(okFee, "fee transfer");
        }
        (bool okSeller, ) = payable(item.seller).call{value: sellerProceeds}("");
        require(okSeller, "seller transfer");

        if (msg.value > item.price) {
            (bool okRefund, ) = payable(msg.sender).call{value: msg.value - item.price}("");
            require(okRefund, "refund");
        }

        emit Sold(nft, tokenId, msg.sender, item.price);
    }
}
