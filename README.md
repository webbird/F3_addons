F3_addons
=========

Some addons I've created for Fat Free Framework

Validate
========

Basic validation class. For now, it cleans up paths and URIs.

Validate::path(<path>)
______________________

Clean up path (remove double //, fix relatives like ./../)

If a path begins with "./", this will be replaced with the dir validate.php is
located. If you need to set another base dir, define a global "BASEDIR" before
you use the validator.

Validate::url(<URI>)
____________________

Clean up URL (remove double //, fix relatives like ./../)

