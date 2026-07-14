# NFTSite

WordPress **NFT marketplace** — theme + companion plugin — with MetaMask **SIWE** login, Sepolia **mint / list / buy**, and a Creator Studio.

**Status: final reference MVP (Sepolia / localhost).**  
Built as a fullstack demo: fixed-price commerce works end-to-end. Not audited, not mainnet-ready.

| Package | Version |
| --- | --- |
| Theme `nftsite` | **1.2.7** |
| Plugin `nftsite-core` | **1.0.10** |

---

## What’s included

### Product
- MetaMask (Sepolia) connect + Sign-In With Ethereum → WP user + artist profile  
- **Creator Studio** — mint with image/title; library updates over AJAX (no full reload)  
- **List for sale** — branded price modal → approve + market list → Studio card updates to `listed`  
- **Buy now** — second wallet can purchase; self-buy blocked  
- NFT detail commerce: Buy / You own this / Listed by you / Not for sale / Sold  
- Marketplace **All / For sale**, status badges, honest live counts  
- Artist profile with real Created / Owned / Collection counts, volume & sold from listings  
- **Edit profile** (name, bio, email, website)  
- Activity on NFT pages + Sepolia Etherscan links  
- Sticky header, toast / tx status UX  

### Stack
| Layer | Path |
| --- | --- |
| Theme | `wp-content/themes/nftsite` |
| Plugin | `wp-content/plugins/nftsite-core` |
| Contracts | `wp-content/plugins/nftsite-core/contracts` (`NFTSite721`, `NFTSiteMarket`) |
| Network | Ethereum Sepolia (`11155111`) |

Catalog truth: WordPress CPTs when present (not seed arrays). Wallet UI: `assets/js/wallet.js` (ethers v6).

---

## Requirements

- WordPress **6.0+**, PHP **7.4+**
- Local (e.g. XAMPP) or any WP host  
- [MetaMask](https://metamask.io/) on **Sepolia** + faucet ETH  
- Node.js (compile/deploy contracts)  
- Sepolia RPC (Alchemy / Infura / public)

---

## Install

1. Copy **theme** and **plugin** into a WordPress site under `wp-content/` (both are required).  
2. Activate theme **nftsite** and plugin **NFTSite Core**.  
3. Create pages and assign templates:

   | Suggested slug | Template |
   | --- | --- |
   | `marketplace` | Marketplace |
   | `nft` | NFT |
   | `artist` | Artist |
   | `rankings` | Rankings |
   | `connect-wallet` | Connect Wallet |
   | `studio` | Creator Studio |
   | `create-account` | Create Account / Edit Profile |

4. **Settings → NFTSite Core**  
   - Sepolia RPC URL  
   - Chain ID `11155111`  
   - NFT + Market contract addresses  
   - Treasury  
   - SIWE domain (`localhost` for local XAMPP)  
5. Optional: **Import theme seed → CPTs** on the same settings screen.

### Admin vs wallet login

- **Site admin** (Plugins, Settings, NFTSite Core): classic WP admin user/password.  
- **SIWE / MetaMask** users are created as **Subscriber** — they only see Dashboard + Profile in wp-admin. That’s intentional.

---

## Smart contracts

```bash
cd wp-content/plugins/nftsite-core/contracts
npm install
cp .env.example .env   # if present; otherwise create .env
```

`.env` (never commit):

```env
SEPOLIA_RPC_URL=https://eth-sepolia.g.alchemy.com/v2/YOUR_KEY
PRIVATE_KEY=0xYOUR_DEPLOYER_KEY
```

```bash
npm run compile
npm run deploy:sepolia
```

Paste printed **NFT**, **Market**, and **Treasury** into **Settings → NFTSite Core**.

### Example Sepolia deployment (this project)

| Role | Address |
| --- | --- |
| NFT (`NFTSite721`) | `0xcceEed7C20317A3c60773Da3C0b26d1F4932F119` |
| Market (`NFTSiteMarket`) | `0x5df80a2Ae0A56a5ED96D0e2690be0A853Af9D274` |
| Treasury | `0xb64EE6323231797E027064931bA8419ccA61D54a` |

Redeploy anytime and update WP settings.

---

## Flows

### Creator
1. Connect / Sign In (MetaMask + SIWE)  
2. Studio → mint  
3. List for sale (modal)  
4. Share NFT URL  

### Buyer
1. Sign in with a **different** MetaMask account  
2. Marketplace → **For sale** (or NFT page)  
3. Buy now → confirm → ownership updates  

---

## REST API

Base: `/wp-json/nftsite/v1/`

| Area | Endpoints |
| --- | --- |
| Auth | `auth/nonce`, `auth/verify`, `auth/me`, `auth/logout` |
| Catalog | `nfts`, `artists`, `collections`, `rankings`, `activity` |
| Trade | `mint/prepare`, `mint/confirm`, `listing/confirm`, `sale/confirm` |
| Disabled | `bid` → auctions not available (`501`) |
| Social / profile | `follow`, `newsletter`, `profile` |

---

## Intentional limits

- Fixed-price only — **no auctions**  
- SIWE soft-verify on by default for localhost (`nftsite_siwe_soft_verify=1`); turn off + real ecrecover for production  
- Images/metadata on WordPress uploads (localhost URLs don’t travel well; use public host or IPFS later)  
- MetaMask only (no WalletConnect)  
- Client confirms txs; server validates hash format — no full RPC receipt verifier  
- Contracts unaudited — **testnet only**

---

## GitHub notes

Suggested repo contents (minimum):

```text
wp-content/themes/nftsite/          # this theme
wp-content/plugins/nftsite-core/    # plugin + contracts/
```

**Do not commit:**

- `contracts/.env` / private keys  
- `contracts/node_modules/`  
- WordPress `uploads/` media dumps (optional)  
- `wp-config.php` with secrets  

Add a root or contracts `.gitignore` covering `.env` and `node_modules`.

---

## Possible follow-ups (out of scope for this freeze)

Cancel/relist, avatar/banner upload, server-side search, site-wide activity page, IPFS, hardened SIWE, mainnet + audit.

---

## License

Theme: GPL v2 or later (Underscores lineage).  
Plugin & Solidity: provided as **unaudited educational / portfolio** code — do not use with real funds on mainnet.
