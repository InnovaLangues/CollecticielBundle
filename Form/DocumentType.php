<?php

namespace Icap\DropzoneBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DocumentType extends AbstractType
{
    private $name ='icap_dropzone_document_file_form';
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['documentType'] == 'text') {
            $this->setName('icap_dropzone_document_file_form_text');
            $builder->add('document', 'tinymce',  array(
                'required' => true,
                
            ));
        } else if ($options['documentType'] == 'file') {
            $this->setName('icap_dropzone_document_file_form_file');
            $builder->add('document', 'file',  array('required' => true, 'label' => 'file document'));
        } else if ($options['documentType'] == 'resource') {
           $this->setName('icap_dropzone_document_file_form_resource');
           $builder->add(
               'document',
               'hidden',
               array(
                   'required' => true,
                   'label' => '',
                   'label_attr' => array('style' => 'display: none;')
               )
           );
        } else {
            $this->setName('icap_dropzone_document_file_form_url');
            $builder->add('document', 'url',  array('required' => true, 'label' => 'url document'));
        }
    }

    public function getName()
    {
        return $this->name;
    }
    public function setName($name){
       $this->name = $name;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'documentType' => 'url',
            'translation_domain' => 'icap_dropzone',
        ));
    }
}