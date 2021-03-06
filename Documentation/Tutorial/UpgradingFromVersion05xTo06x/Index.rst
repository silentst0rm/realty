﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.

.. ==================================================
.. DEFINE SOME TEXTROLES
.. --------------------------------------------------
.. role::   underline
.. role::   typoscript(code)
.. role::   ts(typoscript)
   :class:  typoscript
.. role::   php(code)


Upgrading from version 0.5.x to 0.6.x
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Note: The classic image gallery has been removed for 0.6.x. The
gallery now always uses Lightbox.

#. Make sure that you are using at least TYPO3 4.5 and at least PHP 5.3.

#. Install the latest version of the  *oelib* and  *static\_info\_tables*
   extensions.

#. Update the Realty Manager.

#. Select the “UPDATE” drop-down in the extension manager for the Realty
   Manager. This will assign cities to your district records if the
   relation is unambiguous.

#. If you have any gallery pages, delete them.

#. If you use the FE editor, FE image upload, favorites list of contact
   form, these pages now can be cached. So you can uncheck the “don't
   cache” checkbox for these pages.

#. View your front-end pages that contain the Realty Manager plug-in and
   check that there are no configuration check warnings. If there are any
   warnings, fix your setup and reload that page.

#. In the extension manager, disable “Automatic configuration check”
   (this will improve performance).
