# Upgrading from v1.0.0 to v1.1.x

While this starter kit is intended to be used for fresh projects only, the install between minor versions should always be relatively straight forward using Git -- assuming that your cloned/forked project uses Git.

## Upgrading on a production server
> These are the steps I used to deploy the update to my blog, blog.desilva.se. Your milage may vary. Always make backups before upgrading!

### Step 1: SSH into your production server

### Step 2: Make sure you have an origin set up that connects to the repo. My blog has its own GitHub repo which is cloned from the starter kit master so I will be syncing to that.
```bash
# Note, you only need to do this if your origin is not already set up
git remote add origin https://github.com/<user>/<repo>.git
```

### Step 3: Close down the server using
```bash
php artisan down
```
Now might be a good idea to make a backup of your files and database.

### Step 4: Pull the changes
```bash
git pull origin master

# You may be asked to enter your Git credentials here
```

### Step 5: Update composer dependencies
```bash
composer install --optimize-autoloader --no-dev
```

### Step 6: Run the migrations
```bash
php artisan migrate --force
```

### Step 7: Cache the configuration files (optional)
```bash
php artisan optimize
```

### Step 8: Start the server back up
```bash
php artisan up
```

### Step 9: Visit your site and verify that everything works as expected.

### Known issues when upgrading

#### Posts are unpublished
> Note, this only affects those who upgrade from v1.0.0, not for fresh installs.

Since this update adds a publishing control feature. Since your old posts don't have this the publish date is null which is considered a draft.


##### Steps to fix:
If you want, you can manually set the publish date on your posts.

Or you can use the following code to set the publish date to the created at date.

First you need somewhere to run the code. I'm using the built in Tinker command. Start by entering the shell by using the command `php artisan tinker` and paste the following code:
```php
Post::withoutGlobalScopes()->where(['published_at' => null])->get()->each(function ($post) {
	$post->update(['published_at' => $post->created_at]);
});
```
Once you press enter to execute all the posts will be updated. You can then exit the shell by typing `exit;` and hitting enter.