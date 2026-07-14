// SPDX-License-Identifier: MIT
pragma solidity ^0.8.20;

import "@openzeppelin/contracts/token/ERC721/extensions/ERC721URIStorage.sol";
import "@openzeppelin/contracts/token/common/ERC2981.sol";
import "@openzeppelin/contracts/access/Ownable.sol";

/**
 * @title NFTSite721
 * @notice Sepolia ERC-721 with per-token royalties (ERC2981).
 */
contract NFTSite721 is ERC721URIStorage, ERC2981, Ownable {
    uint256 private _nextId = 1;

    constructor(address initialOwner) ERC721("NFT Marketplace", "NFTM") Ownable(initialOwner) {
        _setDefaultRoyalty(initialOwner, 500);
    }

    function mint(
        address to,
        string memory uri,
        address royaltyReceiver,
        uint96 royaltyBps
    ) external returns (uint256 tokenId) {
        tokenId = _nextId++;
        _safeMint(to, tokenId);
        _setTokenURI(tokenId, uri);
        if (royaltyReceiver != address(0) && royaltyBps > 0) {
            _setTokenRoyalty(tokenId, royaltyReceiver, royaltyBps);
        }
    }

    function supportsInterface(bytes4 interfaceId)
        public
        view
        override(ERC721URIStorage, ERC2981)
        returns (bool)
    {
        return super.supportsInterface(interfaceId);
    }
}
