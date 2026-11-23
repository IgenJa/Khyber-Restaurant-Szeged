<?php

/*
 * Éttermi adatok.
 *
 * A telefonszám, az e-mail, a nyitvatartás és a pontos cím üresen marad,
 * amíg a valós adatok nem ismertek. A weboldal ezeket csak kitöltés után jeleníti meg,
 * az útvonaltervezés és a hívás gombja pedig csak érvényes adat esetén működik.
 */

return [
    'restaurant_name' => 'Khyber Restaurant Szeged',

    // Példa: '+36 30 123 4567'
    'phone' => '',

    // Példa: 'hello@khyber.hu'
    'email' => '',

    // Úgy jelenik meg, ahogy ide beírod. Sortörés megengedett.
    'opening_hours' => [
        'hu' => '',
        'en' => '',
    ],

    // Pontos cím. Amíg üres, a térkép és az útvonaltervezés nem aktív.
    // Példa: 'Széchenyi tér 1., Szeged'
    'address' => '',

    // Google Térkép beágyazási cím. A Google Térképen: Megosztás, majd Térkép beágyazása.
    // Csak a iframe src értékét másold ide, és csak akkor jelenik meg térkép.
    // Példa: 'https://www.google.com/maps/embed?pb=...'
    'maps_embed_url' => '',

    // Az éles webcím, záró perjel nélkül. Közösségi megosztáskor és a hreflang címkékhez kell.
    // Példa: 'https://khyber.hu'
    'site_url' => '',
];
