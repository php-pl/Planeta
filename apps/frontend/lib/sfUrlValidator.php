<?php
class sfUrlValidator extends sfValidator
{
  public function execute(&$value, &$error)
  {
    $re = '/^(http|https|ftp):\/\/(([A-Z0-9][A-Z0-9_-]*)(\.[A-Z0-9][A-Z0-9_-]*)+)(\/[A-Z0-9_.-]*)*([A-Z0-9_.-])*((\?|&)[A-Z0-9_=-]+)*$/i';

    if (!preg_match($re, $value))
    {
      $error = $this->getParameterHolder()->get('url_error');
      return false;
    }

    return true;
  }

  public function initialize($context, $parameters = null)
  {
    parent::initialize($context);

    $this->getParameterHolder()->set('url_error', 'Invalid input');
    $this->getParameterHolder()->add($parameters);

    return true;
  }
}
