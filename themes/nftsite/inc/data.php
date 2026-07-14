<?php
/**
 * Seed marketplace data — single source of truth for demo content.
 *
 * @package nftsite
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @return array<string, array>
 */
function nftsite_seed_artists() {
	static $artists = null;
	if ( null !== $artists ) {
		return $artists;
	}

	$artists = array(
		'animakid'       => array(
			'id'         => 'animakid',
			'name'       => 'Animakid',
			'avatar'     => 'images/artist/avatar-large.png',
			'avatar_sm'  => 'images/avatars/avatar-10.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xc0E3B79C85E3A78CBE3579C',
			'wallet_short' => '0xc0E3...B79C',
			'bio'        => "The internet's friendliest designer kid.",
			'volume'     => '250k+',
			'nfts_sold'  => '50+',
			'followers'  => '3000+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'distant-galaxy', 'life-on-edena', 'astrofiction', 'crypto-city', 'colorful-dog-0524', 'space-tales', 'cherry-blossom-037', 'dancing-robots-0987', 'ice-cream-ape', 'sunset-dimension', 'space-walking' ),
			'owned'      => array( 'distant-galaxy', 'life-on-edena', 'astrofiction' ),
			'collection' => array( 'crypto-city', 'colorful-dog-0524', 'space-tales', 'cherry-blossom-037' ),
			'rank'       => 10,
		),
		'orbitian'       => array(
			'id'         => 'orbitian',
			'name'       => 'Orbitian',
			'avatar'     => 'images/avatars/orbitian.png',
			'avatar_sm'  => 'images/avatars/orbitian.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0x8F2A91B4C7D0E3F1A5B9',
			'wallet_short' => '0x8F2A...B9C1',
			'bio'        => 'Explorer of cosmic curiosities and metal machines.',
			'volume'     => '180k+',
			'nfts_sold'  => '42+',
			'followers'  => '2100+',
			'sales'      => '28.10 ETH',
			'created'    => array( 'the-orbitians', 'foxy-life', 'cat-from-future', 'psycho-dog', 'desert-walk', 'dancing-robot-0375', 'dancing-robot-0356', 'dancing-robot-0321' ),
			'owned'      => array( 'the-orbitians', 'foxy-life', 'cat-from-future' ),
			'collection' => array( 'psycho-dog', 'desert-walk', 'dancing-robot-0375', 'dancing-robot-0356' ),
			'rank'       => 4,
		),
		'keepitreal'     => array(
			'id'         => 'keepitreal',
			'name'       => 'Keepitreal',
			'avatar'     => 'images/avatars/avatar-1.png',
			'avatar_sm'  => 'images/avatars/avatar-1.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0x1A2B3C4D5E6F7081920A',
			'wallet_short' => '0x1A2B...20A3',
			'bio'        => 'Keeping digital art grounded in reality.',
			'volume'     => '120k+',
			'nfts_sold'  => '38+',
			'followers'  => '1800+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'colorful-dog-0356', 'colorful-dog-0344' ),
			'owned'      => array( 'colorful-dog-0356' ),
			'collection' => array( 'colorful-dog-0344' ),
			'rank'       => 1,
		),
		'mrfox'          => array(
			'id'         => 'mrfox',
			'name'       => 'Mr Fox',
			'avatar'     => 'images/avatars/avatar-6.png',
			'avatar_sm'  => 'images/avatars/avatar-6.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xF0X123456789ABCDEF01',
			'wallet_short' => '0xF0X1...F01A',
			'bio'        => 'Sly designs and wild animal collections.',
			'volume'     => '95k+',
			'nfts_sold'  => '29+',
			'followers'  => '1500+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'designer-bear' ),
			'owned'      => array( 'designer-bear' ),
			'collection' => array( 'designer-bear' ),
			'rank'       => 6,
		),
		'shroomie'       => array(
			'id'         => 'shroomie',
			'name'       => 'Shroomie',
			'avatar'     => 'images/avatars/avatar-7.png',
			'avatar_sm'  => 'images/avatars/avatar-7.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0x5HR00M1E23456789ABCD',
			'wallet_short' => '0x5HR0...ABCD',
			'bio'        => 'Magic mushrooms and mycelium dreams.',
			'volume'     => '110k+',
			'nfts_sold'  => '31+',
			'followers'  => '1900+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'magic-mushroom-0325' ),
			'owned'      => array( 'magic-mushroom-0325' ),
			'collection' => array( 'magic-mushroom-0325' ),
			'rank'       => 7,
		),
		'bekind2robots'  => array(
			'id'         => 'bekind2robots',
			'name'       => 'BeKind2Robots',
			'avatar'     => 'images/avatars/avatar-8.png',
			'avatar_sm'  => 'images/avatars/avatar-8.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xB0T987654321FEDCBA98',
			'wallet_short' => '0xB0T9...A98F',
			'bio'        => 'Robots with feelings and disco souls.',
			'volume'     => '88k+',
			'nfts_sold'  => '27+',
			'followers'  => '1400+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'happy-robot-032', 'happy-robot-024', 'dancing-robot-0312' ),
			'owned'      => array( 'happy-robot-032', 'happy-robot-024' ),
			'collection' => array( 'dancing-robot-0312' ),
			'rank'       => 8,
		),
		'moondancer'     => array(
			'id'         => 'moondancer',
			'name'       => 'MoonDancer',
			'avatar'     => 'images/avatars/avatar-13.png',
			'avatar_sm'  => 'images/avatars/avatar-13.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xM00N1111222233334444',
			'wallet_short' => '0xM00N...4444',
			'bio'        => 'Dancing under digital moons.',
			'volume'     => '76k+',
			'nfts_sold'  => '22+',
			'followers'  => '1200+',
			'sales'      => '22.10 ETH',
			'created'    => array( 'cherry-blossom-035', 'distant-galaxy' ),
			'owned'      => array( 'cherry-blossom-035' ),
			'collection' => array( 'distant-galaxy' ),
			'rank'       => 13,
		),
		'nebulakid'      => array(
			'id'         => 'nebulakid',
			'name'       => 'NebulaKid',
			'avatar'     => 'images/avatars/avatar-14.png',
			'avatar_sm'  => 'images/avatars/avatar-14.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xNEB5555666677778888',
			'wallet_short' => '0xNEB5...8888',
			'bio'        => 'Born in a nebula, raised on Ethernet.',
			'volume'     => '64k+',
			'nfts_sold'  => '19+',
			'followers'  => '980+',
			'sales'      => '18.40 ETH',
			'created'    => array( 'space-travel', 'life-on-edena' ),
			'owned'      => array( 'space-travel' ),
			'collection' => array( 'life-on-edena' ),
			'rank'       => 14,
		),
		'spaceone'       => array(
			'id'         => 'spaceone',
			'name'       => 'Spaceone',
			'avatar'     => 'images/avatars/avatar-15.png',
			'avatar_sm'  => 'images/avatars/avatar-15.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xSPC0000111122223333',
			'wallet_short' => '0xSPC0...3333',
			'bio'        => 'First art out of the hyperspace lane.',
			'volume'     => '58k+',
			'nfts_sold'  => '17+',
			'followers'  => '860+',
			'sales'      => '15.20 ETH',
			'created'    => array( 'astrofiction' ),
			'owned'      => array( 'astrofiction' ),
			'collection' => array( 'astrofiction' ),
			'rank'       => 15,
		),
		'robotica'       => array(
			'id'         => 'robotica',
			'name'       => 'Robotica',
			'avatar'     => 'images/avatars/avatar-8.png',
			'avatar_sm'  => 'images/avatars/avatar-8.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xR0B1C2D3E4F5A6B7C8D9',
			'wallet_short' => '0xR0B1...C8D9',
			'bio'        => 'Mechanical rhythms and chrome dreams.',
			'volume'     => '71k+',
			'nfts_sold'  => '21+',
			'followers'  => '1100+',
			'sales'      => '34.53 ETH',
			'created'    => array( 'dancing-robot-0312' ),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 8,
		),
		'iceapeclub'     => array(
			'id'         => 'iceapeclub',
			'name'       => 'IceApeClub',
			'avatar'     => 'images/avatars/avatar-16.png',
			'avatar_sm'  => 'images/avatars/avatar-16.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0x1CE4PE00011122233344',
			'wallet_short' => '0x1CE4...3344',
			'bio'        => 'Cool apes, hot drops.',
			'volume'     => '49k+',
			'nfts_sold'  => '14+',
			'followers'  => '720+',
			'sales'      => '12.40 ETH',
			'created'    => array( 'ice-cream-ape-0324' ),
			'owned'      => array( 'ice-cream-ape-0324' ),
			'collection' => array(),
			'rank'       => 16,
		),
		'puppypower'     => array(
			'id'         => 'puppypower',
			'name'       => 'PuppyPower',
			'avatar'     => 'images/avatars/avatar-12.png',
			'avatar_sm'  => 'images/avatars/avatar-12.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xPUPPY00112233445566',
			'wallet_short' => '0xPUPP...5566',
			'bio'        => 'Good boys on the blockchain.',
			'volume'     => '41k+',
			'nfts_sold'  => '12+',
			'followers'  => '640+',
			'sales'      => '10.10 ETH',
			'created'    => array( 'colorful-dog-0344' ),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 12,
		),
		'digilab'        => array(
			'id'         => 'digilab',
			'name'       => 'DigiLab',
			'avatar'     => 'images/avatars/avatar-2.png',
			'avatar_sm'  => 'images/avatars/avatar-2.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xD1G1LAB112233445566',
			'wallet_short' => '0xD1G1...5566',
			'bio'        => 'Lab-grown pixels.',
			'volume'     => '33k+',
			'nfts_sold'  => '11+',
			'followers'  => '540+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 2,
		),
		'gravityone'     => array(
			'id'         => 'gravityone',
			'name'       => 'GravityOne',
			'avatar'     => 'images/avatars/avatar-3.png',
			'avatar_sm'  => 'images/avatars/avatar-3.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xGR4V1TY112233445566',
			'wallet_short' => '0xGR4V...5566',
			'bio'        => 'Pulling collectors into orbit.',
			'volume'     => '29k+',
			'nfts_sold'  => '10+',
			'followers'  => '510+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 3,
		),
		'juanie'         => array(
			'id'         => 'juanie',
			'name'       => 'Juanie',
			'avatar'     => 'images/avatars/avatar-4.png',
			'avatar_sm'  => 'images/avatars/avatar-4.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xJU4N1E11223344556677',
			'wallet_short' => '0xJU4N...6677',
			'bio'        => 'Color-first creator.',
			'volume'     => '27k+',
			'nfts_sold'  => '9+',
			'followers'  => '480+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 4,
		),
		'bluewhale'      => array(
			'id'         => 'bluewhale',
			'name'       => 'BlueWhale',
			'avatar'     => 'images/avatars/avatar-5.png',
			'avatar_sm'  => 'images/avatars/avatar-5.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xBLUeWH4LE1122334455',
			'wallet_short' => '0xBLUe...4455',
			'bio'        => 'Deep sea volume plays.',
			'volume'     => '25k+',
			'nfts_sold'  => '8+',
			'followers'  => '450+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 5,
		),
		'cloudy'         => array(
			'id'         => 'cloudy',
			'name'       => 'Cloudy',
			'avatar'     => 'images/avatars/avatar-9.png',
			'avatar_sm'  => 'images/avatars/avatar-9.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xCL0UDY11223344556677',
			'wallet_short' => '0xCL0U...6677',
			'bio'        => 'Soft gradients, soft launches.',
			'volume'     => '22k+',
			'nfts_sold'  => '7+',
			'followers'  => '410+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 9,
		),
		'dotgu'          => array(
			'id'         => 'dotgu',
			'name'       => 'Dotgu',
			'avatar'     => 'images/avatars/avatar-11.png',
			'avatar_sm'  => 'images/avatars/avatar-11.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xD0TGU112233445566778',
			'wallet_short' => '0xD0TG...7788',
			'bio'        => 'Dots that connect cultures.',
			'volume'     => '20k+',
			'nfts_sold'  => '6+',
			'followers'  => '390+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 11,
		),
		'ghiblier'       => array(
			'id'         => 'ghiblier',
			'name'       => 'Ghiblier',
			'avatar'     => 'images/avatars/avatar-12.png',
			'avatar_sm'  => 'images/avatars/avatar-12.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xGH1BL1ER112233445566',
			'wallet_short' => '0xGH1B...5566',
			'bio'        => 'Studio-story vibes in every frame.',
			'volume'     => '18k+',
			'nfts_sold'  => '5+',
			'followers'  => '360+',
			'sales'      => '34.53 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 12,
		),
		'danial'         => array(
			'id'         => 'danial',
			'name'       => 'Danial',
			'avatar'     => 'images/avatars/avatar-3.png',
			'avatar_sm'  => 'images/avatars/avatar-3.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xD4N14L11223344556677',
			'wallet_short' => '0xD4N1...6677',
			'bio'        => 'Moonbirds and midnight minting.',
			'volume'     => '52k+',
			'nfts_sold'  => '16+',
			'followers'  => '800+',
			'sales'      => '21.00 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 17,
		),
		'jimmy'          => array(
			'id'         => 'jimmy',
			'name'       => 'Jimmy',
			'avatar'     => 'images/avatars/avatar-4.png',
			'avatar_sm'  => 'images/avatars/avatar-4.png',
			'banner'     => 'images/artist/banner.png',
			'wallet'     => '0xJ1MMY1122334455667788',
			'wallet_short' => '0xJ1MM...7788',
			'bio'        => 'Neo echoes from the underground.',
			'volume'     => '47k+',
			'nfts_sold'  => '15+',
			'followers'  => '760+',
			'sales'      => '19.50 ETH',
			'created'    => array(),
			'owned'      => array(),
			'collection' => array(),
			'rank'       => 18,
		),
	);

	return $artists;
}

/**
 * @return array<string, array>
 */
function nftsite_seed_nfts() {
	static $nfts = null;
	if ( null !== $nfts ) {
		return $nfts;
	}

	$defaults = array(
		'price'       => '1.63 ETH',
		'bid'         => '0.33 wETH',
		'tags'        => array( 'ART', 'COLLECTIBLE' ),
		'minted'      => 'Minted On Sep 30, 2022',
		'description' => array(
			'A unique digital collectible on the NFT Marketplace.',
			'Own a piece of the universe crafted for collectors and creators alike.',
		),
		'countdown'   => '59:59:59',
	);

	$items = array(
		'space-walking'          => array( 'title' => 'Space Walking', 'image' => 'images/hero/space-walking.png', 'artist_id' => 'animakid', 'hero' => 'images/hero/space-walking.png', 'tags' => array( 'SPACE', 'ANIMATION' ) ),
		'the-orbitians'          => array(
			'title'       => 'The Orbitians',
			'image'       => 'images/nfts/orbitian-nft.png',
			'hero'        => 'images/nft-detail/orbitians-hero.png',
			'artist_id'   => 'orbitian',
			'tags'        => array( 'ANIMATION', 'ILLUSTRATION', 'MOON', 'SPACE' ),
			'minted'      => 'Minted On Sep 30, 2022',
			'description' => array(
				'The Orbitians is a collection of 10,000 unique NFTs on the Ethereum blockchain.',
				'There are all sorts of beings in the NFT Universe. The most advanced and friendly of the group is The Orbitians.',
				'They live in metal machines, and have the spirit of travel and discovery, always looking for a new adventure and discoveries.',
				'With spaceships, traveling the cosmos is the easiest of tasks for these peaceful inhabitants.',
			),
		),
		'distant-galaxy'         => array( 'title' => 'Distant Galaxy', 'image' => 'images/nfts/distant-galaxy.png', 'artist_id' => 'animakid' ),
		'life-on-edena'          => array( 'title' => 'Life On Edena', 'image' => 'images/nfts/life-on-edena.png', 'artist_id' => 'animakid' ),
		'astrofiction'           => array( 'title' => 'AstroFiction', 'image' => 'images/nfts/astrofiction.png', 'artist_id' => 'animakid' ),
		'crypto-city'            => array( 'title' => 'CryptoCity', 'image' => 'images/nfts/crypto-city.png', 'artist_id' => 'animakid' ),
		'colorful-dog-0524'      => array( 'title' => 'ColorfulDog 0524', 'image' => 'images/nfts/colorful-dog-0524.png', 'artist_id' => 'animakid' ),
		'space-tales'            => array( 'title' => 'Space Tales', 'image' => 'images/nfts/space-tales.png', 'artist_id' => 'animakid' ),
		'cherry-blossom-037'     => array( 'title' => 'Cherry Blossom Girl 037', 'image' => 'images/nfts/cherry-blossom-037.png', 'artist_id' => 'animakid' ),
		'dancing-robots-0987'    => array( 'title' => 'Dancing Robots 0987', 'image' => 'images/nfts/dancing-robots-0987.png', 'artist_id' => 'animakid' ),
		'ice-cream-ape'          => array( 'title' => 'IceCream Ape', 'image' => 'images/nfts/ice-cream-ape.png', 'artist_id' => 'animakid' ),
		'sunset-dimension'       => array( 'title' => 'Sunset Dimension', 'image' => 'images/nfts/sunset-dimension.png', 'artist_id' => 'animakid' ),
		'magic-mushroom-0325'    => array( 'title' => 'Magic Mushroom 0325', 'image' => 'images/nfts/magic-mushroom-0325.png', 'artist_id' => 'shroomie' ),
		'happy-robot-032'        => array( 'title' => 'Happy Robot 032', 'image' => 'images/nfts/happy-robot-032.png', 'artist_id' => 'bekind2robots' ),
		'happy-robot-024'        => array( 'title' => 'Happy Robot 024', 'image' => 'images/nfts/happy-robot-024.png', 'artist_id' => 'bekind2robots' ),
		'designer-bear'          => array( 'title' => 'Designer Bear', 'image' => 'images/nfts/designer-bear.png', 'artist_id' => 'mrfox' ),
		'colorful-dog-0356'      => array( 'title' => 'Colorful Dog 0356', 'image' => 'images/nfts/colorful-dog-0345.png', 'artist_id' => 'keepitreal' ),
		'dancing-robot-0312'     => array( 'title' => 'Dancing Robot 0312', 'image' => 'images/nfts/dancing-robot.png', 'artist_id' => 'robotica' ),
		'cherry-blossom-035'     => array( 'title' => 'Cherry Blossom Girl 035', 'image' => 'images/nfts/cherry-blossom.png', 'artist_id' => 'moondancer' ),
		'space-travel'           => array( 'title' => 'Space Travel', 'image' => 'images/nfts/space-travel.png', 'artist_id' => 'nebulakid' ),
		'desert-walk'            => array( 'title' => 'Desert Walk', 'image' => 'images/nfts/desert-walk.png', 'artist_id' => 'orbitian' ),
		'ice-cream-ape-0324'     => array( 'title' => 'IceCream Ape 0324', 'image' => 'images/nfts/ice-cream-ape.png', 'artist_id' => 'iceapeclub' ),
		'colorful-dog-0344'      => array( 'title' => 'Colorful Dog 0344', 'image' => 'images/nfts/colorful-dog-0356.png', 'artist_id' => 'puppypower' ),
		'foxy-life'              => array( 'title' => 'Foxy Life', 'image' => 'images/nfts/foxy-life.png', 'artist_id' => 'orbitian' ),
		'cat-from-future'        => array( 'title' => 'Cat From Future', 'image' => 'images/nfts/cat-from-future.png', 'artist_id' => 'orbitian' ),
		'psycho-dog'             => array( 'title' => 'Psycho Dog', 'image' => 'images/nfts/psycho-dog.png', 'artist_id' => 'orbitian' ),
		'dancing-robot-0375'     => array( 'title' => 'Dancing Robot 0375', 'image' => 'images/nfts/dancing-robot.png', 'artist_id' => 'orbitian' ),
		'dancing-robot-0356'     => array( 'title' => 'Dancing Robot 0356', 'image' => 'images/nfts/dancing-robot-0345.png', 'artist_id' => 'orbitian' ),
		'dancing-robot-0321'     => array( 'title' => 'Dancing Robot 0321', 'image' => 'images/nfts/dancing-robot-0387.png', 'artist_id' => 'orbitian' ),
	);

	$nfts = array();
	foreach ( $items as $id => $item ) {
		$nfts[ $id ] = array_merge( $defaults, $item, array( 'id' => $id ) );
		if ( empty( $nfts[ $id ]['hero'] ) ) {
			$nfts[ $id ]['hero'] = $nfts[ $id ]['image'];
		}
	}

	return $nfts;
}

/**
 * @return array<string, array>
 */
function nftsite_seed_collections() {
	return array(
		'dsgn-animals'    => array(
			'id'      => 'dsgn-animals',
			'title'   => 'DSGN Animals',
			'artist_id' => 'mrfox',
			'primary' => 'images/collections/dsgn-animals/primary.png',
			'thumb_1' => 'images/collections/dsgn-animals/thumb-1.png',
			'thumb_2' => 'images/collections/dsgn-animals/thumb-2.png',
			'extra'   => '1025',
			'trending'=> true,
		),
		'moonbirds'       => array(
			'id'      => 'moonbirds',
			'title'   => 'Moonbirds',
			'artist_id' => 'danial',
			'primary' => 'images/collections/moonbirds/primary.png',
			'thumb_1' => 'images/collections/moonbirds/thumb-1.png',
			'thumb_2' => 'images/collections/moonbirds/thumb-2.png',
			'extra'   => '781',
			'trending'=> true,
		),
		'neo-echos'       => array(
			'id'      => 'neo-echos',
			'title'   => 'Neo Echos',
			'artist_id' => 'jimmy',
			'primary' => 'images/collections/neonecho/primary.png',
			'thumb_1' => 'images/collections/neonecho/thumb-1.png',
			'thumb_2' => 'images/collections/neonecho/thumb-2.png',
			'extra'   => '532',
			'trending'=> true,
		),
		'magic-mushrooms' => array(
			'id'      => 'magic-mushrooms',
			'title'   => 'Magic Mushrooms',
			'artist_id' => 'shroomie',
			'primary' => 'images/collections/moonbirds/primary.png',
			'thumb_1' => 'images/collections/moonbirds/thumb-1.png',
			'thumb_2' => 'images/collections/moonbirds/thumb-2.png',
			'extra'   => '781',
		),
		'disco-machines'  => array(
			'id'      => 'disco-machines',
			'title'   => 'Disco Machines',
			'artist_id' => 'bekind2robots',
			'primary' => 'images/collections/neonecho/primary.png',
			'thumb_1' => 'images/collections/neonecho/thumb-1.png',
			'thumb_2' => 'images/collections/neonecho/thumb-2.png',
			'extra'   => '532',
		),
		'space-walking'   => array(
			'id'      => 'space-walking',
			'title'   => 'Space Walking',
			'artist_id' => 'animakid',
			'primary' => 'images/nfts/space-travel.png',
			'thumb_1' => 'images/nfts/distant-galaxy.png',
			'thumb_2' => 'images/nfts/astrofiction.png',
			'extra'   => '312',
		),
		'orbitian-worlds' => array(
			'id'      => 'orbitian-worlds',
			'title'   => 'Orbitian Worlds',
			'artist_id' => 'orbitian',
			'primary' => 'images/nfts/orbitian-nft.png',
			'thumb_1' => 'images/nfts/desert-walk.png',
			'thumb_2' => 'images/nfts/sunset-dimension.png',
			'extra'   => '204',
		),
		'neon-dogs'       => array(
			'id'      => 'neon-dogs',
			'title'   => 'Neon Dogs',
			'artist_id' => 'keepitreal',
			'primary' => 'images/nfts/colorful-dog-0345.png',
			'thumb_1' => 'images/nfts/colorful-dog-0356.png',
			'thumb_2' => 'images/nfts/designer-bear.png',
			'extra'   => '156',
		),
	);
}

/**
 * Rankings rows (20) with per-period stats for tab switching.
 *
 * @return array<int, array>
 */
function nftsite_seed_rankings() {
	$names = array(
		array( 'name' => 'Jaydon Ekstrom Bothman', 'avatar' => 1, 'artist_id' => 'keepitreal' ),
		array( 'name' => 'Ruben Carder', 'avatar' => 2, 'artist_id' => 'digilab' ),
		array( 'name' => 'Alfredo Septimus', 'avatar' => 3, 'artist_id' => 'gravityone' ),
		array( 'name' => 'Davis Franci', 'avatar' => 4, 'artist_id' => 'juanie' ),
		array( 'name' => 'Livia Rosser', 'avatar' => 5, 'artist_id' => 'bluewhale' ),
		array( 'name' => 'Kianna Donin', 'avatar' => 6, 'artist_id' => 'mrfox' ),
		array( 'name' => 'Phillip Lipshutz', 'avatar' => 7, 'artist_id' => 'shroomie' ),
		array( 'name' => 'Maria Rosser', 'avatar' => 8, 'artist_id' => 'bekind2robots' ),
		array( 'name' => 'Kianna Stanton', 'avatar' => 9, 'artist_id' => 'cloudy' ),
		array( 'name' => 'Angel Lubin', 'avatar' => 10, 'artist_id' => 'animakid' ),
		array( 'name' => 'Allison Torff', 'avatar' => 11, 'artist_id' => 'dotgu' ),
		array( 'name' => 'Davis Workman', 'avatar' => 12, 'artist_id' => 'ghiblier' ),
		array( 'name' => 'Lindsey Lipshutz', 'avatar' => 13, 'artist_id' => 'moondancer' ),
		array( 'name' => 'Randy Carder', 'avatar' => 14, 'artist_id' => 'nebulakid' ),
		array( 'name' => 'Lydia Culhane', 'avatar' => 15, 'artist_id' => 'spaceone' ),
		array( 'name' => 'Rayna Bator', 'avatar' => 16, 'artist_id' => 'iceapeclub' ),
		array( 'name' => 'Jocelyn Westervelt', 'avatar' => 17, 'artist_id' => 'danial' ),
		array( 'name' => 'Marilyn Torff', 'avatar' => 18, 'artist_id' => 'jimmy' ),
		array( 'name' => 'Skylar Levin', 'avatar' => 19, 'artist_id' => 'orbitian' ),
		array( 'name' => 'Terry Dorwart', 'avatar' => 20, 'artist_id' => 'puppypower' ),
	);

	$rows = array();
	foreach ( $names as $i => $row ) {
		$base_sold   = 602 - ( $i * 7 );
		$base_volume = 12.4 - ( $i * 0.15 );
		$rows[]      = array(
			'name'      => $row['name'],
			'avatar'    => 'images/avatars/avatar-' . $row['avatar'] . '.png',
			'artist_id' => $row['artist_id'],
			'periods'   => array(
				'today' => array(
					'change' => '+' . number_format( 1.41 + ( $i % 5 ) * 0.22, 2 ) . '%',
					'sold'   => (string) max( 12, (int) ( $base_sold * 0.08 ) ),
					'volume' => number_format( max( 0.4, $base_volume * 0.12 ), 1 ) . ' ETH',
				),
				'week'  => array(
					'change' => '+' . number_format( 2.10 + ( $i % 4 ) * 0.31, 2 ) . '%',
					'sold'   => (string) max( 40, (int) ( $base_sold * 0.35 ) ),
					'volume' => number_format( max( 1.2, $base_volume * 0.4 ), 1 ) . ' ETH',
				),
				'month' => array(
					'change' => '+' . number_format( 3.55 + ( $i % 6 ) * 0.18, 2 ) . '%',
					'sold'   => (string) max( 120, (int) ( $base_sold * 0.7 ) ),
					'volume' => number_format( max( 4.0, $base_volume * 0.75 ), 1 ) . ' ETH',
				),
				'all'   => array(
					'change' => '+' . number_format( 1.41 + ( $i % 3 ) * 0.1, 2 ) . '%',
					'sold'   => (string) max( 200, $base_sold ),
					'volume' => number_format( max( 5.0, $base_volume ), 1 ) . ' ETH',
				),
			),
		);
	}

	return $rows;
}

/**
 * Marketplace NFT slug order (desktop design).
 *
 * @return string[]
 */
function nftsite_marketplace_nft_ids( $filter = 'all' ) {
	$filter = in_array( $filter, array( 'all', 'listed' ), true ) ? $filter : 'all';
	if ( function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog() ) {
		$args = array(
			'post_type'      => 'nftsite_nft',
			'post_status'    => 'publish',
			'posts_per_page' => 48,
			'orderby'        => 'date',
			'order'          => 'DESC',
			'fields'         => 'ids',
			'no_found_rows'  => true,
		);
		if ( 'listed' === $filter ) {
			$args['meta_query'] = array(
				array(
					'key'   => '_nftsite_status',
					'value' => 'listed',
				),
			);
		}
		$q   = new WP_Query( $args );
		$ids = array();
		foreach ( $q->posts as $pid ) {
			$p = get_post( $pid );
			if ( $p ) {
				$ids[] = $p->post_name;
			}
		}
		if ( $ids || 'listed' === $filter ) {
			return $ids;
		}
	}
	return array(
		'magic-mushroom-0325',
		'happy-robot-032',
		'happy-robot-024',
		'designer-bear',
		'colorful-dog-0356',
		'dancing-robot-0312',
		'cherry-blossom-035',
		'space-travel',
		'sunset-dimension',
		'desert-walk',
		'ice-cream-ape-0324',
		'colorful-dog-0344',
	);
}

/**
 * Marketplace collection ids.
 *
 * @return string[]
 */
function nftsite_marketplace_collection_ids() {
	if ( function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog() ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_collection',
				'post_status'    => 'publish',
				'posts_per_page' => 24,
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$ids = array();
		foreach ( $q->posts as $pid ) {
			$p = get_post( $pid );
			if ( $p ) {
				$ids[] = $p->post_name;
			}
		}
		if ( $ids ) {
			return $ids;
		}
	}
	return array( 'dsgn-animals', 'magic-mushrooms', 'disco-machines', 'space-walking', 'orbitian-worlds', 'neon-dogs' );
}

/**
 * Homepage top creators order.
 *
 * @return string[]
 */
function nftsite_home_creator_ids() {
	$seed = array(
		'keepitreal',
		'digilab',
		'gravityone',
		'juanie',
		'bluewhale',
		'mrfox',
		'shroomie',
		'robotica',
		'cloudy',
		'animakid',
		'dotgu',
		'ghiblier',
	);
	if ( function_exists( 'nftsite_core_has_catalog' ) && nftsite_core_has_catalog() ) {
		$q = new WP_Query(
			array(
				'post_type'      => 'nftsite_artist',
				'post_status'    => 'publish',
				'posts_per_page' => 12,
				'orderby'        => 'title',
				'order'          => 'ASC',
				'fields'         => 'ids',
				'no_found_rows'  => true,
			)
		);
		$ids = array();
		foreach ( $q->posts as $pid ) {
			$p = get_post( $pid );
			if ( $p ) {
				$ids[] = $p->post_name;
			}
		}
		if ( $ids ) {
			// Prefer seed order when those artists exist.
			$ordered = array();
			foreach ( $seed as $slug ) {
				if ( in_array( $slug, $ids, true ) ) {
					$ordered[] = $slug;
				}
			}
			foreach ( $ids as $slug ) {
				if ( ! in_array( $slug, $ordered, true ) ) {
					$ordered[] = $slug;
				}
			}
			return array_slice( $ordered, 0, 12 );
		}
	}
	return $seed;
}
