Laravel Feedback Form
---

This is a simple form to gather feedback from the users of your application.

There's no magic here. This library only publishes the files needed to handle
this workflow, and adds it into your existing Laravel application and build
process. That makes it 100% customizable.

Requirements:
* Bootstrap
* Laravel 5+

## Installation
```shell
composer require clevyr/laravel-feedback-form

# Publish the added files
php artisan vendor:publish --provider="Clevyr\FeedbackForm\FeedbackServiceProvider"
```

## Environment Variables

This app depends on environment variables:

```
Required:
FEEDBACK_EMAIL=user@example.com # the recipient of the feedback email

Optional:
FEEDBACK_ENABLED=true # Whether you want to show the feedback form
```

## Usage
Include this Vue directive anywhere in your blade/vue templates:
```
<feedback-form />
```

You can conditionally show the form in blade templates like this:
```
@if (config('feedback.enabled'))
  <feedback-form />
@endif
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
