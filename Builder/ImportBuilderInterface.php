<?php

namespace Sonata\AdminBundle\Builder;

use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;


interface ImportBuilderInterface
{
    /**
     * @abstract
     * @param array $options
     * @return void
     */
    function getBaseList(array $options = array());

    /**
     * @abstract
     * @param \Sonata\AdminBundle\Admin\FieldDescriptionCollection $list
     * @param null|mixed $type
     * @param \Sonata\AdminBundle\Admin\FieldDescriptionInterface $fieldDescription
     * @param \Sonata\AdminBundle\Admin\AdminInterface $admin
     */
    function addField(FieldDescriptionCollection $import, $type = null, FieldDescriptionInterface $fieldDescription, AdminInterface $admin);

    /**
     * @abstract
     * @param \Sonata\AdminBundle\Admin\AdminInterface $admin
     * @param \Sonata\AdminBundle\Admin\FieldDescriptionInterface $fieldDescription
     */
    function fixFieldDescription(AdminInterface $admin, FieldDescriptionInterface $fieldDescription);
}
