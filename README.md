# GlotPress Whitelabel Studio

A WordPress plugin that rebrands the front end of a **GlotPress** site with your own logo, name, colors and footer, all set from one settings page with no theme or template edits.

## Key Features

1.  **Branding:** Set the brand name (used in the browser tab title and the header home link) and a tagline shown under the logo.
2.  **Logo options:** Use the default Backcourt SVG logo, upload your own image from the Media Library (with a height setting), or show the brand name as text.
3.  **Color presets:** Choose from five built-in palettes, or pick custom colors for the header, accent, primary buttons and table headers.
4.  **Footer credit:** Replace the footer "Powered by" line. HTML links are allowed.
5.  **Project search:** Adds a search box to the main projects page that matches project names, descriptions and slugs.
6.  **Admin bar for admins:** Shows the WordPress admin bar on GlotPress pages to users who can `manage_options`.

---

## 1. Requirements

*   WordPress with [GlotPress](https://wordpress.org/plugins/glotpress/) active.
*   PHP 7.4 or newer.

---

## 2. Installation

1.  Download the latest `gp-whitelabel-x.y.z.zip` from the [Releases page](https://github.com/helgatheviking/gp-whitelabel/releases).
2.  In WordPress, go to **Plugins > Add New > Upload Plugin** and upload the zip.
3.  Activate **GlotPress Whitelabel Studio**.

Install from the release zip, not a clone of this repository. The zip includes the bundled Composer dependencies that the plugin needs.

### Updates

The plugin uses [Git Updater Lite](https://github.com/afragen/git-updater-lite) to get updates from `https://www.backcourt.io`. New releases show up under **Dashboard > Updates** like any other plugin.

---

## 3. Settings

Go to **Settings > GlotPress Whitelabel**.

| Section | Settings |
|---------|----------|
| Branding & Logo | Brand title, header tagline, logo display mode, custom logo image, logo height |
| Color Schemes | Color preset, header background, header text, accent color, primary button colors (normal and hover) |
| Footer | "Powered by" text or link |

Picking a color preset fills in the color pickers. The saved colors are always the ones in the pickers, so you can start from a preset and adjust any of them.

---

## 4. Template Overrides

The plugin adds its `templates/` folder to the front of GlotPress's template search path, so these files replace GlotPress's own versions:

| Template | Purpose |
|----------|---------|
| `header.php` | Logo, brand name and tagline |
| `footer.php` | Copyright line and "Powered by" credit |
| `projects.php` | Projects list with the search box |

Colors are applied as CSS custom properties added inline after `assets/css/style.css`.

---

## 5. Translations

The text domain is `gp-whitelabel`. The release build generates `languages/gp-whitelabel.pot`.

Strings that GlotPress already has (such as "Projects" and "Inactive") keep the `glotpress` text domain, so they use GlotPress's existing translations.

---

## 6. Development

```bash
npm install
composer install
```

`composer install` runs [Strauss](https://github.com/BrianHenryIE/strauss), which copies the dependencies into `vendor-prefixed/` under the `HelgaTheViking\GP_Whitelabel\Vendor` namespace. This stops them from clashing with other plugins that load the same libraries.

| Command | What it does |
|---------|--------------|
| `composer run make-pot` | Generates `languages/gp-whitelabel.pot` |
| `composer run i18n` | Generates the POT and JSON translation files |
| `npm run build` | Installs production dependencies, generates the POT and writes the zip to `deploy/gp-whitelabel.zip` |

### Releasing

```bash
npm version patch
```

Use `minor` or `major` as needed, or a pre-release version such as `npm version 1.1.0-beta.1`.

This updates the version in `package.json` and the plugin header, commits the change, tags it and pushes. The tag starts the [Release workflow](.github/workflows/release.yml), which:

1.  Builds the zip with production dependencies and a fresh POT file.
2.  Writes a changelog from the commit messages since the previous tag.
3.  Publishes a GitHub release with `gp-whitelabel-x.y.z.zip` attached. Tags containing `-alpha`, `-beta` or `-rc` are marked as pre-releases.
4.  For stable releases only, clears the Git Updater cache on backcourt.io so sites see the update right away. This step needs the `BACKCOURT_GITUPDATER_KEY` repository secret.

#### Tag check hook (optional)

`bin/verify-tag.js` refuses to create a tag that doesn't match the version in `package.json`. To turn it on locally:

```bash
printf '#!/bin/sh\nnode "$(dirname "$0")/../../bin/verify-tag.js" "$@"\n' > .git/hooks/reference-transaction && chmod +x .git/hooks/reference-transaction
```

---

## License

GPL-2.0-or-later
