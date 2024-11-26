# Enhanced Relation form widget

The aim of this plugin is to study the possible support of tree display for relation form fields.

## Prerequisites

The model associated with the field must use the `Winter\Storm\Database\Traits\NestedTree` trait.

## Installation

Copy this plugin into the `/plugins/hounddd/enhancedrelation` directory of your Winter CMS installation.

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
