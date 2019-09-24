Laravel Feedback Form
---

This is a simple form to gather feedback from the users of your application.

Requirements:
* Bootstrap
* Laravel 5+

## Installation
```shell
composer install --save clevyr/laravel-feedback-form

php artisan vendor:publish --provider="Clevyr\LaravelFeedbackForm\FeedbackServiceProvider"
```

## Usage
Include this Vue directive anywhere in your blade/vue templates:
```
<feedback-form />
```

#### Optional Params
You can pre-populate the name and email fields on the form using the `name` and
`email` props.

```
<feedback-form
  name="{{ someName }}"
  email="{{ someEmail }}"
/>
```

## License

MIT
