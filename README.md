# Enhanced Relation form widget

The aim of this plugin is to study the possible support of tree display for relation form fields.

## Prerequisites

The model associated with the field must use the `Winter\Storm\Database\Traits\NestedTree` trait.

## Installation
*Let assume you're in the root of your wintercms installation*

### Using composer
Just run this command
```bash
composer require hounddd/wn-enhancedrelation-plugin
```

### Clone
Clone this repo into your winter plugins folder.

```bash
cd plugins
mkdir hounddd && cd hounddd
git clone https://github.com/Hounddd/wn-enhancedrelation-plugin enhancedrelation
```

> **Note**:
> In both cases, run `php artisan migrate` command to run plugin's migrations

## Usage

Replace the type `relation` with `enhanced-relation` in your form field definition.

```yaml
categories:
    label: 'Categories'
    nameFrom: name
    # type: relation
    type: enhanced-relation
    quickselect: true
    displayTree: true
    quickTreeActions: true

```
## New options

- `displayTree` : Display the tree structure of the relation.
- `quickTreeActions` : Display buttons on the top of the widget to open all, closse all or open only selected nodes.
