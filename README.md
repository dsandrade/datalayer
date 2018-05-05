# Datalayer
[![Source](http://img.shields.io/badge/source-caffeinated/repository-blue.svg?style=flat-square)](https://github.com/1giba/datalayer)
[![License](http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://tldrlegal.com/license/mit-license)

> A simplest abstraction layer for eloquent models

Inspired in:

* [caffeinated/repository](https://github.com/caffeinated/repository)
* [Jeffrey Way's Lesson](https://github.com/laracasts/Dedicated-Query-String-Filtering/)
* [spatie/laravel-query-builder](https://github.com/spatie/laravel-query-builder)

# Installation

It is recommended that you install the package using Composer.

```sh
$ composer require 1giba/datalayer
```

This package is compliant with [PSR-1](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md), [PSR-2](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md), and [PSR-4](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md). If you find any compliance oversights, please send a patch via pull request.

# Using Repositories

### Create a Model
Create your model like you normally would. We'll be wrapping our repository around our model to access and query the database for the information we need.

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model

class Book extends Model
{
    //
}
```

### Create a Repository
Create a new Repository class - usually these classes are simply stored within a `Repositories` directory. There are a few requirements for each repository instance:

- Repository classes must extend the DataLayer Repository class.
- Repository classes must specify a property pointing to the model.
- Repository classes must specify an array of cache tags. These tags are used by the package to handle automatic cache busting when relevent values change within the database.

```php
<?php

namespace App\Repositories;

use App\Models\Book;
use OneGiba\DataLayer\Repository;

class BookRepository extends Repository
{
    /**
     * @var string
     */
    protected $model = Book::class;

    /**
     * @var array
     */
    protected $tag = ['book'];
}
```

### Injecting a Repository
Once you've built and configured your repository instance, you may inject the class within your classes where needed:

```php
<?php

namespace App\Http\Controllers;

use App\Repositories\BookRepository;

class BookController extends Controller
{
    /**
     * @var BookRepository
     */
    protected $book;

    /**
     * Create a new BookController instance.
     *
     * @param  BookRepository  $book
     */
    public function __construct(BookRepository $book)
    {
        $this->book = $book;
    }

    /**
     * Display a listing of all books.
     *
     * @return Response
     */
    public function index()
    {
        $books = $this->book->findAll();

        return view('books.index', compact('books'));
    }
}
```
