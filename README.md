# Mage2 Module Shawatech Mostviewed

    ``shawatech/module-mostviewed``

 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Sort products by most viewed products

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the zip file in `app/code/Shawatech`
 - Enable the module by running `php bin/magento module:enable Shawatech_Mostviewed`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

## Specifications

 - Crongroup
	- shawatech

 - Cronjob
	- shawatech_mostviewed_updatemostviewedproducts


## Attributes

 - Product - Most Viewed (most_viewed)

