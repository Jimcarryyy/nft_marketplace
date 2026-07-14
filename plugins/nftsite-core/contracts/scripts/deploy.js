const hre = require("hardhat");

async function main() {
  const [deployer] = await hre.ethers.getSigners();
  const treasury = process.env.TREASURY || deployer.address;
  const feeBps = Number(process.env.PLATFORM_FEE_BPS || 250);

  console.log("Deployer:", deployer.address);

  const NFT = await hre.ethers.getContractFactory("NFTSite721");
  const nft = await NFT.deploy(deployer.address);
  await nft.waitForDeployment();
  const nftAddress = await nft.getAddress();
  console.log("NFTSite721:", nftAddress);

  const Market = await hre.ethers.getContractFactory("NFTSiteMarket");
  const market = await Market.deploy(deployer.address, treasury, feeBps);
  await market.waitForDeployment();
  const marketAddress = await market.getAddress();
  console.log("NFTSiteMarket:", marketAddress);

  console.log("\nPaste into WP Admin → Settings → NFTSite Core:");
  console.log("nftsite_nft_contract =", nftAddress);
  console.log("nftsite_market_contract =", marketAddress);
  console.log("nftsite_treasury =", treasury);
}

main().catch((error) => {
  console.error(error);
  process.exitCode = 1;
});
