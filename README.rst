﻿.. ==================================================
.. FOR YOUR INFORMATION
.. --------------------------------------------------
.. -*- coding: utf-8 -*- with BOM.


.. _start:

.. image:: https://travis-ci.org/r3h6/TYPO3.EXT.error404page.svg?branch=master
    :target: https://travis-ci.org/r3h6/TYPO3.EXT.error404page

=============
Documentation
=============

Custom error 404 pages made simple.

Use TYPO3 pages for display 404 errors. Optional error 403 redirect handling. Works for multi domain and multilingual installations.


How it works
------------

This extension adds a new custom page type for rendering 404 documents.

This extensions overrides the ``['FE']['pageNotFound_handling']`` configuration with its own configuration.


Screenshots
-----------

.. figure:: ./Documentation/Images/ModulePage.png
   :alt: New page type.
   :width: 400px

.. figure:: ./Documentation/Images/ModuleStatistic.png
   :alt: Optional statistic backend module.
   :width: 400px


Installation
------------

Through `TER <https://typo3.org/extensions/repository/view/error404page/>`_ or with `composer <https://composer.typo3.org/satis.html#!/error404page>`_ (typo3-ter/error404page).


Integration
-----------

Simply install the extension and create a new page with your error message.

* No TypoScript setup to include.

You can use following markers in your content.

.. t3-field-list-table::
 :header-rows: 1

 - :Key:
      Marker
   :Description:
      Description

 - :Key:
      ###CURRENT_URL###
   :Description:
      The url of the called page.

 - :Key:
      ###REASON###
   :Description:
      A text why the error occured.

 - :Key:
      ###ERROR_STATUS_CODE###
   :Description:
      404|403

If you like redirect non logged in users when a 403 (forbidden) error occurs,
simply include the available "Page TSConfig" or define by yourself:

``tx_error404page.redirectError403To = auto | [url] | [uid]``


Configuration
-------------

Extension configuration
^^^^^^^^^^^^^^^^^^^^^^^

.. t3-field-list-table::
 :header-rows: 1

 - :Key:
      Key
   :Description:
      Description

 - :Key:
      doktypeError404page
   :Description:
      If required, you can change the page type.

 - :Key:
      enableErrorLog
   :Description:
      Enables the error log and statistic backend modul.

 - :Key:
      excludeErrorLogPattern
   :Description:
      Regex without delimiters (/ /) and modifiers (i).

      Example: select|union

 - :Key:
      basicAuthentication
   :Description:
      Username and password for basic authentication.

 - :Key:
      debug
   :Description:
      Enable debug log.


.. warning::

   If you change the page type, you must update the doktype of your previously created error pages by yourself.


Log and statistic
-----------------

If log is enabled, the last 10'000 errors are logged and listed in the backend module "Errors".


FAQ
---

How it works?
   The error handler makes a request to fetch the error page and returns it.

Instead of the error page, the home page is shown?
   Perhaps you have some htaccess rules that redirects the error handler's request.
   Make sure it is possible to call your error page directly (ex. http://typo3.request.host/index.php?id=123&type=0&L=0&tx_error404page_request=ab12cd34de56).

How to redirect 403 (Forbidden) errors to a login page?
   Please read the section "Integration".


Contributing
------------

Bug reports
^^^^^^^^^^^

Bug reports are welcome through `GitHub <https://github.com/r3h6/TYPO3.EXT.error404page/issues/>`_.

Please submit with your issue the debug log. Enable it in the extension configuration and clear the frontend cache before reproducing the failure.

Pull request
^^^^^^^^^^^^

Pull request are welcome through `GitHub <https://github.com/r3h6/TYPO3.EXT.error404page/>`_.

Please not that pull requests to the *master* branch will be ignored. Please pull to the *develop* branch.


Changelog
---------

:3.0.0: Support for TYPO3 8.6, dropped support for TYPO3 6.2
:2.1.1: Bugfix for language detection with realurl 1.x.x
:2.1.0: Added exclude pattern for error log
:2.0.0: Refactoring, Feature 403 redirects
:1.3.0: Updated backend modul
:1.2.0: TYPO3 6.2 compatibility
:1.1.0: Feature error log
:1.0.0: First release