=== Raise Prices with Sales for WooCommerce ===
Contributors: ibenic 
Tags: woocommerce, sales, ecommerce
Requires at least: 4.7
Tested up to: 4.7.4
Stable tag: 1.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Define multiple Sales Points and increase prices after a defined amount of sales.

== Description ==

Define sales points and let WordPress & WooCommerce increase the price of the product after a defined amount of sales.

**WooCommerce 3.0 is requested. It won't work on version below 3.0.**

This plugin will directly change the **Regular Price** of your product, it won't save the regular price since it will be changed directly. This is done so that you may also delete all the sales points but retain the last price change of your product.

Under the product price, there will be a notice for your customers that the price for this product will increase after X sales.


== Installation ==

This section describes how to install the plugin and get it working.

1. Upload the folder `rps_wc` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress 

== Frequently Asked Questions ==

= Will the original price remain? =

No. We make changes directly on the product regular price. This will ensure that your product is on the correct price even if you deactive this plugin or delete sales points by accident.

= When will the regular price be updated? =

Regular price will be updated only if the number of sales gets to a defined amount. Sales are not counted if the order has not been marked as **completed**.

== Screenshots ==

1. Product Sales Point Information
2. Defining Sales Points

== Changelog ==

= 1.0 =
* Initial release
