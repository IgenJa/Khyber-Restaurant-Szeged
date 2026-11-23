# Khyber Restaurant Szeged

Bemutató weboldal a Khyber Restaurant számára. Egyoldalas, magyar és angol nyelvű éttermi oldal, amely megmutatja, hogyan nézhetne ki egy modern, igényes honlap. PHP-n fut, adatbázis és keretrendszer nélkül.

A mintafogások csak szemléltetésre szolgálnak. Az oldalon szándékosan nincs ár, pontos cím, telefonszám és nyitvatartás, amíg ezek nincsenek megadva a `config.php` fájlban.

## Mappaszerkezet

```text
index.php              A weboldal
config.php             Név, telefon, e-mail, cím, nyitvatartás, térkép
includes/header.php    Fejléc, metaadatok
includes/footer.php    Lábléc
lang/hu.php            Magyar szövegek
lang/en.php            Angol szövegek
assets/css/style.css   Megjelenés, színek
assets/js/main.js      Menü, görgetés, animáció
assets/images/         Fotók és favicon
```

## Helyi futtatás

A mappában, ahol az `index.php` van:

```text
php -S localhost:8000
```

Ezután a böngészőben: [http://localhost:8000](http://localhost:8000)

Ha a `php` parancs nem elérhető, XAMPP esetén:

```text
C:\xampp\php\php.exe -S localhost:8000
```

A magyar az alapértelmezett nyelv. Az angol változat: `http://localhost:8000/index.php?lang=en`

## Feltöltés Rackhostra

1. Lépj be a Rackhost fájlkezelőjébe vagy FTP-re.
2. Nyisd meg a domain gyökerét, általában a `public_html` vagy a `www` mappa.
3. Töltsd fel a projekt összes fájlját és mappáját úgy, hogy az `index.php` közvetlenül ebben a gyökérben legyen.
4. A tárhelynél PHP 8 legyen beállítva.
5. Nyisd meg a domain címét. Ha a nyelv vagy a megosztási kép abszolút címet kér, írd be a `config.php` `site_url` mezőjébe a webcímet, perjel nélkül. Példa: `https://khyber.hu`

Adatbázist nem kell létrehozni.

## Éttermi adatok

A `config.php` fájlban cserélhető:

- `phone` — nemzetközi formátum ajánlott, például `+36 30 123 4567`
- `email`
- `opening_hours` — külön a `hu` és az `en` szöveg; sortörés megengedett
- `address` — pontos cím; ettől kezd működni az útvonaltervezés, és megjelenik a térkép
- `maps_embed_url` — nem kötelező; a Google Térkép „Megosztás → Térkép beágyazása” ablakából az iframe `src` címe
- `site_url` — az éles webcím

Üres mezőt az oldal nem talál ki, és nem jelenít meg helyette kitalált adatot.

## Szövegek

A magyar szövegek a `lang/hu.php`, az angol szövegek a `lang/en.php` fájlban vannak. A látogatónak szánt szöveg az idézőjelek között áll. Az idézőjelet a szövegen belül `\'` formában kell írni, a sor végi vesszőt pedig meg kell hagyni.

Új ételt a `menu` → `items` listához lehet hozzáadni mindkét nyelvi fájlban, azonos `id` értékkel. A kép az `index.php` tetején lévő `$images` tömbhöz tartozik.

## Képek

A fotók az `assets/images/` mappában vannak. Ugyanazzal a fájlnévvel cseréld le őket, és az elrendezés változatlan marad:

- `hero.jpg` — nyitóképernyő
- `about.jpg` — rólunk
- `samosa.jpg`, `daal.jpg`, `biryani.jpg`, `gulab-jamun.jpg`, `mango-lassi.jpg` — étlap

A jelenlegi képek ideiglenes bemutatófotók, szabad felhasználású forrásból:

- Pexels: 1624487, 2802527, 4449068, 2474661, 15014919, 14509267
- Unsplash: `photo-1589302168068-964664d93dc0`

A képek alt szövege a nyelvi fájlokban van.

## Színek

A paletta az `assets/css/style.css` fájl elején, a `:root` blokkban van. A legfontosabb változók:

- `--charcoal` — mély szénfekete
- `--ivory` — meleg elefántcsont
- `--burgundy` — bordó
- `--gold` — tompa arany
- `--muted` — meleg szürke

A betűtípus a Playfair Display a címekhez és az Inter a szöveghez. Mindkettő a `includes/header.php` fájlban van behívva.
