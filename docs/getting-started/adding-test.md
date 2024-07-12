---
layout:
  title:
    visible: true
  description:
    visible: false
  tableOfContents:
    visible: true
  outline:
    visible: true
  pagination:
    visible: true
---

# ➕ Adding test

You can create tests file for a specific model with the following command:

```
php artisan make:laravel-unit-test ModelName
```

{% hint style="info" %}
You can also use the following command:

```
php artisan make:laravel-unit-test
```

and write the model name in the insert provided.
{% endhint %}

{% hint style="warning" %}
The model name is case-sensitive, you have to write it as it is.

In all cases, a check of the model's existence is performed after entering.
{% endhint %}

{% hint style="danger" %}
to overload existing test, you can use the tag:

```
--force
```
{% endhint %}
