---
title: "New feature: Write posts directly with Markdown files!"
description: "Example post"
published: "2022-01-01 12:00"
tags: "tags, are separated, with commas"
featured_image: "https://picsum.photos/960/640"
author: 1
---

# Welcome

**Hello world**, this is a blog post created as a flat markdown file using frontmatter.

```yaml
--‎-
title: "New feature: Write posts directly with Markdown files!"
description: "Example post"
published: "2022-01-01 12:00" # YYYY-MM-DD HH:MM
tags: "tags, are separated, with commas"
featured_image: "https://picsum.photos/960/640"
author: 1 # The user ID
--‎-

# Markdown here
```

The slug is generated from the filename and the updated_at time is generated from the time the file was last modified.

The post can then be retrived as an Eloquent model using the parser
```php
$parser = new \App\Http\Controllers\MarkdownFileParser;
$model = $parser
	->parse('example-post') // The file to parse
	->save() // Save it to the database
	->get() // Get an instance of the model
```