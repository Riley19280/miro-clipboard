
<p align="center">
    <p align="center">
        <a href="https://github.com/riley19280/miro-clipboard/actions"><img alt="GitHub Workflow Status (master)" src="https://img.shields.io/github/actions/workflow/status/riley19280/miro-clipboard/run-tests.yml?branch=main&label=Tests"></a>
        <a href="https://packagist.org/packages/riley19280/miro-clipboard"><img alt="Total Downloads" src="https://img.shields.io/packagist/dt/riley19280/miro-clipboard"></a>
        <a href="https://packagist.org/packages/riley19280/miro-clipboard"><img alt="Latest Version" src="https://img.shields.io/packagist/v/riley19280/miro-clipboard"></a>
        <a href="https://packagist.org/packages/riley19280/miro-clipboard"><img alt="License" src="https://img.shields.io/packagist/l/riley19280/miro-clipboard"></a>
    </p>
</p>

# Introduction

`miro-clipboard` allows you to generate and parse Miro clipboard data, 
allowing custom functionality to be built into existing applications with a simple Copy and Paste.

This package also serves to document the various properties and identifiers that are utilized in the clipboard data. 

## Creating Clipboard Data

Clipboard data is created using the `MiroClipboardData` class, and consists of multiple objects that can be added to it. 

```php
MiroClipboardData::make()
->addObject(MiroWidget::make()->shape(ShapeType::Circle))
->toHtml();
```

The following object types are available:
- [MiroShape](https://github.com/Riley19280/miro-clipboard/blob/main/src/Objects/MiroShape.php)
- [MiroLine](https://github.com/Riley19280/miro-clipboard/blob/main/src/Objects/MiroLine.php)

Finally, the `toHtml` method is used to retrieve the Miro data string that can be pasted. 
See [Pasting clipboard data](#pasting-clipboard-data) on how to properly paste into Miro.

Various methods are available on the Widget Objects to configure their position, size, style, and many other attributes. 
See below for a more complete example of what properties are available.

<details>
  <summary>MiroShape Example</summary>

</details>

```php
MiroWidget::make()
    ->shape(ShapeType::Star)
    ->text('Hello!')
    ->scale(.5)
    ->relativeScale(.5)
    ->rotation(90)
    ->relativeRotation(90)
    ->offsetPosition(50, 50)
    ->position(50, 50)
    ->size(50, 50)
    ->style(fn(MiroShapeStyle $style) => $style
        ->backgroundColor(16711680)->backgroundColor('#FF0000')
        ->backgroundOpacity(.5)
        ->borderColor(16711680)->borderColor('#FF0000')
        ->borderThickness(5)
        ->borderOpacity(.5)
        ->borderStyle(BorderStyle::DashLong)
        ->fontFamily('Arial')
        ->textColor(16711680)->textColor('#FF0000')
        ->textAlign(TextAlign::Left, VerticalTextAlign::Top)
        ->fontSize(11)
        ->bold()
        ->italic()
        ->underline()
        ->strikethrough()
    );
```

<details>
  <summary>MiroLine Example</summary>

```php
MiroWidget::make()
    ->line()
    ->addText(
        MiroLineText::make('Hello', .5, .5)
            ->color('#FF0000')
            ->color(16711680)
            ->rotated()
            ->fontSize(11)
            ->width(50)
    )
    ->setPoints([
        ['x' => 111.0, 'y' => 111.0],
        ['x' => 123.0, 'y' => 123.0],
        ['x' => 456.0, 'y' => 456.0],
        ['x' => 500.0, 'y' => 500.0],
    ])
    ->style(fn(MiroLineStyle $style) => $style
        ->jump()
        ->type(LineType::Square)
        ->strokeWeight(4)
        ->color('#FF0000')
        ->color(16711680)
        ->startingLinecap(LineCap::Circle)
        ->endingLinecap(LineCap::CircleFilled)
        ->pattern(LinePattern::Dotted)
    );
```
</details>

### Pasting clipboard data

In order to paste the data into Miro, the resulting string needs to be copied as the `text/html` content type,
which may or may not get applied depending on your computer. To combat this, a file called `clipboardLoader.html`
is included in this repository. It provides a way to load the copied string into the clipboard as the correct content type
so that it can be pasted into Miro.

If you are using this package to integrate into an existing application, then you will 
want to do something similar to load the data directly.


## Parsing Clipboard Data

Existing clipboard data can also be parsed into objects. This is done using the `MiroParser` class.

```php
$objects = MiroParser::parse('<your clipboard string');
```

This results in a list of MiroObject classes.
