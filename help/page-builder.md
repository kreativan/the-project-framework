# Page builder

```php
$args = [
  'folder' => 'layout/my-blocks/', // blocks layout folder
  'container_class' => "uk-container-small",
  'split_section' => [
    'style' => 'primary',
    'space' => 'no-space',
    'class' => 'my-custom-class',
  ],
];

tpf_include('html/page-builder', $args);
```
