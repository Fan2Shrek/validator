# Sruuua validator

A easy to use validator use for validate form

<br>

## How it works

```php

use App\Validator\Constraint;
use App\Validator\Constraint\String\StringValidator;

class Artcile{

    #[Constraint(StringValidator::class)]
    private string $name;
}
```

You can add some parameter like

```php

use App\Validator\Constraint;
use App\Validator\Constraint\String\StringValidator;

class Artcile{

    #[Constraint(StringValidator::class, 'This field is required', ['maxLenght' => 255, 'maxLenghtMsg' => 'This name is too long', 'multipleMessages' => true])]
    private string $name;

    #[Constraint(StringValidator::class, 'This field is required', ['minLenght' => 50, 'minLenghtMsg' => 'This content is too shot', 'multipleMessages' => false])]
    private string $content;
}
```
