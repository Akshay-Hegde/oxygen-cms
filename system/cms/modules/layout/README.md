# Layout module for PyroCMS

The Layout module for PyroCMS provides Twig-like templating functionality in the Lex language

- version - 1.0.0
- Authors - Fredi Bach - fredi.bach@getunik.com | Lukas Angerer - lukas.angerer@getunik.com
- Website - [getunik AG](http://www.getunik.com)

## What is it?

A template is supposed to provide structure for content that is defined outside of the template. While features like insertion of variables, includes and plugins are certainly essential to this, there is one very fundamental thing missing from the PyroCMS Lex template system: content blocks. The ability to define a placeholder in any layout file that can be used in a view to inject entire blocks of content into this placeholder. People familiar with [Twig's _extends_ functionality](http://twig.sensiolabs.org/doc/tags/extends.html) certainly know what I am referring to. The idea is simple: template inheritance. You define a base template that contains placeholders and then your actual layout files simply extend this base template and define the content for the placeholders it contains.

The layout module only consists of a single plugin with three methods. Together with some basic knowledge of the view rendering process, you can do quite a lot with those three methods.

## How does it work?

### Placeholder
* **name:** layout:placeholder
* **attributes:**
    * **name:** the name of the placeholder
```
{{ layout:placeholder name="placeholdername" }}
  default content
{{ /layout:placeholder }}
```
The placeholder tag is a double tag and as such **always** needs a closing tag, even if it doesn't have content. Its content can be any Lex markup you want. If the rendered view does not contain any definition for the placeholder's content, the default content is what is going to be rendered. Placeholder names should be **unique**; you _can_ define the same placeholder twice, but of course both will always contain the exact same content if it is defined as a partial. Due to the limitations of the PyroCMS Lex parsing process, the content (partial) for a placeholder has to be defined **before** the placeholder is rendered. The placeholder plugin simply performs a lookup if there has been content defined for the placeholder's name and inserts it if available.

### Partial
* **name:** layout:partial
* **attributes:**
    * **name:** the name of the placeholder where the defined content should be injected
```
{{ layout:partial name="placeholdername" }}
  content
{{ /layout:partial }}
```
The partial tag defines content for the named placeholder. Partial content (as opposed to the placeholder's default content) is always processed, even if there is no placeholder with the given name, in which case the content is simply not rendered in the output. Just like the placeholder tag, the partial content is parsed for Lex markup with the parser context at the point where the partial call appears. Once the content is parsed and processed, it is placed in the partial store using the placeholder name as its key. This means that if your view contains multiple partial definitions for the same placeholder, only the last one defined before the placeholder is parsed will be used, all previous partial definitions for the same placeholder are overwritten.

### Extend
* **name:** layout:extend
* **attributes:**
    * **file:** the path to the base template relative to the current theme's views directory
```
{{ layout:extend file="layouts/base-template.html" }}
  {{ layout:partial name="placeholdername" }}
  {{ /layout:partial }}
  ...
{{ /layout:extend }}
```
Strictly speaking, it is not neccessary to use the extend functionality, you could do almost anything just with the placeholder and partial tags. It is just an easy way to organize your layouts in a hierarchical and DRY fashion. The extend tag essentially just (parses and) inserts the content of the specified base template **after** processing its own body. Nothing contained in the body of the extend tag is going to be rendered into the output directly (only indirectly through placeholders). This means that putting anything besides partial tags inside of it is quite pointless.

### Nested Templates
Traditionally, the Lex parser is not very good at working with nested structures. Having two tags of the same name nested inside one another doesn't work because of its eager parsing - the first closing tag will close the first of the two nested tags and break everything. To work around this limitation and allow you to create nice nested layouts, the layout plugin supports arbitrary suffixes for its tags to make them unique.

```
{{ layout:extend_outer file="layouts/outer-template.html" }}
  {{ layout:partial_outer name="someplaceholder" }}
    before
    {{ layout:extend_inner file="layouts/inner-template.html" }}
      {{ layout:partial_inner name="someotherplaceholder" }}
      {{ /layout:partial_inner }}
    {{ /layout:extend_inner }}
    after
  {{ /layout:partial_outer }}
{{ /layout:extend_outer }}
```

You can just append an underscore ('_') and a unique string to the plugin call. As long as you make sure that the opening tag name matches the closing tag name, all of those calls are mapped to the same plugin function.

## Things you should (already) know

### PyroCMS Parsing Order
Since the partial for a placeholder has to be parsed (defined) before its placeholder, you should be aware of the order in which things get parsed and processed in a normal PyroCMS request.

1. Before anything having to do with views is ever done, all WYSIWYG fields retrieved from the database which have tags enabled (in the field options) are parsed. This includes the main content of any PyroCMS page.
2. If there is a view file involved (not a PyroCMS page), the view is parsed.
3. If it is a PyroCMS page, the page type's Layout (WYSIWYG) field is parsed.
4. The theme layout (if any) is parsed

## Examples

### Nice, reusable layouts

**Base Template (layouts/base-template.html)**
```
<!DOCTYPE html>
<html>
<head>...</head>
<body>
    <div>
        {{ layout:placeholder name="content" }}
            {{ template:body }}
        {{ /layout:placeholder }}
    </div>
    <div>
        {{ layout:placeholder name="sidebar" }}
            My standard sidebar definition
        {{ /layout:placeholder }}
    </div>
</body>
```

**Layout (layouts/default.html)**
```
{{ layout:extend file="layouts/base-template.html" }}
  {{ layout:partial name="content" }}
    {{ template:body }}
    Some fixed content
    {{ layout:placeholder name="post-body" }}
    {{ /layout:placeholder }}
  {{ /layout:partial }}
  {{ layout:partial name="sidebar" }}
    Specialized Sidebar
  {{ /layout:partial }}
{{ /layout:extend_outer }}
```

**View File**
```
This is regular view content that will be parsed and inserted into the layout as the template body.
{{ layout:partial name="post-body" }}
  P.S: templates ROCK!
{{ /layout:partial }}
```

**Resulting Output**
```
<!DOCTYPE html>
<html>
<head>...</head>
<body>
    <div>
        This is regular view content that will be parsed and inserted into the layout as the template body.
        Some fixed content
        P.S: templates ROCK!
    </div>
    <div>
        Specialized Sidebar
    </div>
</body>
```

## Known Limitations

* Currently, the extend tag only works with templates in the theme's views directory (because that is what it was originally intended to do), meaning that you cannot really use the extend feature for your module views.
