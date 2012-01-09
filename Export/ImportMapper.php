<?php

namespace Sonata\AdminBundle\Export;

use Sonata\AdminBundle\Admin\AdminInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionInterface;
use Sonata\AdminBundle\Model\ModelManagerInterface;
use Sonata\AdminBundle\Admin\FieldDescriptionCollection;
use Sonata\AdminBundle\Builder\ImportBuilderInterface;

/**
 * This class is used to simulate the Form API
 *
 */
class ImportMapper
{
    protected $importBuilder;

    protected $import;

    protected $admin;

    public function __construct(ImportBuilderInterface $importBuilder, FieldDescriptionCollection $import, AdminInterface $admin)
    {
        $this->importBuilder  = $importBuilder;
        $this->import         = $import;
        $this->admin        = $admin;
    }

    public function addIdentifier($name, $type = null, array $fieldDescriptionOptions = array())
    {
        $fieldDescriptionOptions['identifier'] = true;

        return $this->add($name, $type, $fieldDescriptionOptions);
    }

    /**
     * @throws \RuntimeException
     *
     * @param mixed $name
     * @param mixed $type
     * @param array $fieldDescriptionOptions
     * @return \Sonata\AdminBundle\Export\ImportMapper
     */
    public function add($name, $type = null, array $fieldDescriptionOptions = array())
    {
        if ($name instanceof FieldDescriptionInterface) {
            $fieldDescription = $name;
            $fieldDescription->mergeOptions($fieldDescriptionOptions);
        } else if (is_string($name) && !$this->admin->hasListFieldDescription($name)) {
            $fieldDescription = $this->admin->getModelManager()->getNewFieldDescriptionInstance(
                $this->admin->getClass(),
                $name,
                $fieldDescriptionOptions
            );
        } else {
            throw new \RuntimeException('invalid state');
        }

        if (!$fieldDescription->getLabel()) {
            $fieldDescription->setOption('label', $this->admin->getLabelTranslatorStrategy()->getLabel($fieldDescription->getName(), 'list', 'label'));
        }

        // add the field with the ImportBuilder
        $this->importBuilder->addField($this->import, $type, $fieldDescription, $this->admin);

        return $this;
    }

    /**
     * @param string $name
     * @return array
     */
    public function get($name)
    {
        return $this->import->get($name);
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        return $this->import->has($key);
    }

    /**
     * @param  string $key
     * @return \Sonata\AdminBundle\Export\ImportMapper
     */
    public function remove($key)
    {
        $this->admin->removeListFieldDescription($key);
        $this->import->remove($key);

        return $this;
    }
}
