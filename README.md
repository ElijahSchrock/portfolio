# Portfolio

Laravel 13 portfolio with Livewire 4, Jetstream 5, Media Library 11, Tailwind CSS 4, and Vite 8.

## Local development with Laravel Herd

Requirements: Herd with PHP 8.5 and Node.js 26. The `.nvmrc` file tells Herd which Node version this project uses.

Open PowerShell in the project directory. For a new checkout:

```powershell
herd link portfolio --isolate=8.5
herd composer install
nvm install 26
nvm use 26
npm ci
Copy-Item .env.example .env
New-Item -ItemType File database/database.sqlite
herd php artisan key:generate
herd php artisan migrate
herd php artisan storage:link
npm run build
```

Copy `.env.example` and create the SQLite file only when those files do not already exist. Generate an application key only when setting up a new environment.

Open **http://portfolio.test**. Herd serves Laravel in the background; keep Herd running.

For automatic browser refreshes while editing PHP, Blade, CSS, and JavaScript:

```powershell
npm run dev
```

Alternatively, manage Vite through Herd:

```powershell
herd processes:start vite
herd processes:output vite
herd processes:stop vite
```

Run one Vite server at a time. `npm run build` creates assets that work when the Vite server is stopped.

The local defaults use an empty SQLite database at `database/database.sqlite`, public uploads in `storage/app/public`, and email written to `storage/logs/laravel.log`. Seed your owner account as described below, sign in at **http://portfolio.test/login**, then visit **http://portfolio.test/dashboard** to add projects. Existing portfolio content and production media are not included in a fresh database.

To inspect the local database in TablePlus, create a **SQLite** connection named **Portfolio Local** and select this checkout's `database/database.sqlite` file. SQLite does not need a host, port, username, or password. Run `herd php artisan migrate --seed` to restore the portfolio entries after configuring Spaces access below.

For deployment, configure your database, mail, `APP_URL`, `FILESYSTEM_CLOUD`, and `MEDIA_DISK` in that environment. The DigitalOcean Spaces disk remains available through the `DO_SPACES_*` settings in `config/filesystems.php`.

## Owner account

Public registration is disabled: neither GET nor POST `/register` is registered. Only the account marked `is_owner` can log in or manage portfolio content. Admin routes and Livewire components enforce this authorization, including editors opened through the public modal handler. Existing non-owner records are preserved but cannot log in or access the admin.

Set `OWNER_NAME`, `OWNER_EMAIL`, and `OWNER_PASSWORD` in the private `.env` or your deployment service's secret settings. Use a quoted password of 12-72 characters. No password is committed to Git, and the database stores a password hash. Create the initial owner with:

```powershell
herd php artisan config:clear
herd php artisan migrate
herd php artisan db:seed --class=OwnerSeeder
```

The deployment database command also runs `OwnerSeeder`. Its first run creates the owner or promotes the existing account with that email, applying the chosen initial password. Later runs preserve the owner's current name, email, password, and two-factor settings. A stable database flag identifies the owner even after profile changes. Missing credentials stop the initial seed instead of creating a default account. You can remove `OWNER_PASSWORD` from the environment after provisioning; clear or rebuild the configuration cache afterward. Use the profile page or password reset flow for later password changes.

## Deployment seed data

The initial project details and existing Spaces object keys live in `database/seeders/data/portfolio.php`. The manifest restores eight projects: Three.js Arcade, Dream, Astro, Syphon, Eclipse, Neo Runner, AI Lunch & Learn, and Phantom Portrait Poltergeist. Their covers, banners, and logos were matched to the original bucket artwork. Descriptions were reconstructed from that artwork and the supplied technology stacks. Unknown years and additional technologies remain null and are omitted from the public project details; they can be filled in through the admin later.

`DatabaseSeeder` calls `OwnerSeeder`, then `PortfolioSeeder`. The `seed_key` migration gives each seeded project a stable identity. Keep each entry's `key` unchanged after its first deployment. Seed runs create missing records and media without replacing existing descriptions, ordering, or attachments edited through the admin. New entries are imported on later runs. Deleting a seeded project and seeding again recreates that entry.

Add the Spaces settings from `.env.example` to each environment. These credentials stay in `.env`. `DO_SPACES_ENDPOINT` is the regional API endpoint, such as `https://sfo3.digitaloceanspaces.com`; `DO_SPACES_BUCKET` is the bucket name. `DO_SPACES_URL` is optional and can point at a configured CDN URL.

The source disk is `do`. Imported media is copied to `FILESYSTEM_CLOUD`, and the bucket originals are preserved. Local development defaults to the `public` destination, so local copies live under ignored `storage/app/public`. For production, set:

```dotenv
FILESYSTEM_CLOUD=do
MEDIA_DISK=do
MEDIA_PREFIX=portfolio
```

Use a new, dedicated destination folder for `MEDIA_PREFIX` so the import does not overlap the existing bucket objects, then keep this value unchanged after importing. Thumbnail generation may use temporary server files; image binaries are not stored in the seed manifest or committed to Git.

To inspect existing image object keys without changing the bucket:

```sh
php artisan portfolio:spaces-files --prefix=existing-folder --json
```

Omit `--prefix` to list images from the bucket root. The default limit is 100 image objects; use `--limit` to choose up to 500.

After installing Composer dependencies, add this database step to the deployment script:

```sh
composer run deploy:database
```

This runs `php artisan migrate --seed --force --no-interaction`. Missing source files stop the import with their object key in the error. Once corrected, rerun the same command; completed attachments are skipped.

The deployment service still needs this command added to its deployment workflow. Running migrations alone does not invoke seeders unless `--seed` is supplied.

## Checks and dependency updates

```powershell
herd php artisan test
composer validate --strict
composer outdated --direct
composer audit
npm outdated
npm audit
npm run build
```

Tests use an isolated in-memory SQLite database. Tests for disabled Jetstream API and email-verification features are skipped.

Both lockfiles are tracked in Git. Use `herd composer update --with-all-dependencies` and `npm update` for compatible updates, and review migration guides before changing major versions.

The npm override for Tailwind Typography upgrades its pinned selector parser to the patched 7.x release. Keep it until the upstream package adopts the patched dependency.
