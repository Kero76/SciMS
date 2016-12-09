<?php
    namespace SciMS\Controller\BuildDomain;

    use \SciMS\Domain\Article;
    use \SciMS\Form\Input\InputHidden;
    use \SciMS\Form\Input\InputSubmit;
    use \SciMS\Form\Input\InputText;
    use \SciMS\Form\Option;
    use \SciMS\Form\Select;
    use \SciMS\Form\TextArea;

    /**
     * Class BuildEdit
     *
     * This class build domain objects present on Edit page.
     *
     * @author Kero76
     * @package SciMS\Controller\BuildDomain
     * @since SciMS 0.3
     * @version 1.0
     */
    class BuildEditArticle extends AbstractBuildDomain {
    
        /**
         * BuildCategory constructor.
         *
         * @param $template
         *  Name of the template.
         * @since SciMS 0.3
         * @version 1.0
         */
        public function __construct($template) {
            $this->setTemplateName($template);
        }
    
        /**
         * Method use for create domains array use to render the view.
         *
         * @param array $services
         *  Return services.
         * @return array
         *  Return an array who composed by all services present on Router.
         * @since   SciMS 0.3
         * @version 1.0
         */
        public function buildDomain(array $services) {
            $services['get.handler']->setRequest($_GET);         // Retrieve $_GET.
            $user    = $services['dao.user']->findById($services['session.handler']->getRequestField('user_id'));
            $article = $services['dao.article']->findById($services['get.handler']->getRequestField('article'));
    
            // Create the object datalist for the category.
            $categories = $services['dao.category']->findAll();
            $select_category = new Select(array(
                'id'    => 'category',
                'name'  => 'category',
                'label' => 'Category',
                'class' => 'form-control',
            ));
    
            // Fill option in Select object.
            foreach ($categories as $category) {
                // If the article.category.id == category.id, so selected it directly on view.
                if ($category->getId() == $article->getCategories()->getId()) {
                    $select_category->add(new Option(array(
                        'value'     => $category->getId(),
                        'label'     => $category->getTitle(),
                        'selected'  => true,
                    )));
                } else {
                    $select_category->add(new Option(array(
                        'value'     => $category->getId(),
                        'label'     => $category->getTitle(),
                        'selected'  => false,
                    )));
                }
            }
            $select_category->renderSelect();
    
            // Status
            $select_status = new Select(array(
                'id'    => 'status',
                'name'  => 'status',
                'label' => 'status',
                'class' => 'form-control',
            ));
    
            // Fill option in Select object0
            $status = array(
                'Release' => Article::RELEASE,
                'Pending' => Article::PENDING,
                'Hidden'  => Article::HIDDEN
            );
    
            foreach ($status as $key => $value) {
                // If the article.category.id == category.id, so selected it directly on view.
                if ($value == $article->getStatus()) {
                    $select_status->add(new Option(array(
                        'value'     => $value,
                        'label'     => $key,
                        'selected'  => true,
                    )));
                } else {
                    $select_status->add(new Option(array(
                        'value'     => $value,
                        'label'     => $key,
                        'selected'  => false,
                    )));
                }
            }
            $select_status->renderSelect();
    
            // Summary
            $select_summary = new Select(array(
                'id'    => 'summary',
                'name'  => 'summary',
                'label' => 'Display summary',
                'class' => 'form-control',
            ));
    
            $summary = array(
                'Display Summary'   => 1,
                'Undisplay Summary' => 2,
            );
    
            foreach ($summary as $key => $value) {
                // If the article.category.id == category.id, so selected it directly on view.
                if ($value === $article->getDisplayedSummary()) {
                    $select_summary->add(new Option(array(
                        'value'     => $value,
                        'label'     => $key,
                        'selected'  => true,
                    )));
                } else {
                    $select_summary->add(new Option(array(
                        'value'     => $value,
                        'label'     => $key,
                        'selected'  => false,
                    )));
                }
            }
            $select_summary->renderSelect();
    
            $domains = array(
                'forms'  => $services['form.builder']->add(
                // Title
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'title',
                        'name'  => 'title',
                        'class' => 'form-control',
                        'label' => 'Title',
                        'value' => $article->getTitle(),
                    ))
                )->add(
                // Abstract
                    new TextArea(array(
                        'id'        => 'abstract',
                        'name'      => 'abstract',
                        'class'     => 'form-control',
                        'label'     => 'Abstract',
                        'rows'      => '10',
                        'cols'      => '50',
                        'content'   => $article->getAbstract(),
                    ))
                )->add(
                // Content
                    new TextArea(array(
                        'id'        => 'content',
                        'name'      => 'content',
                        'class'     => 'form-control',
                        'label'     => 'Content',
                        'rows'      => '10',
                        'cols'      => '50',
                        'content'   => $article->getContent(),
                    ))
                )->add(
                // Authors
                    new TextArea(array(
                        'id'        => 'authors',
                        'name'      => 'authors',
                        'class'     => 'form-control',
                        'label'     => 'Authors',
                        'rows'      => '5',
                        'cols'      => '50',
                        'content'   => $article->getAuthors(),
                    ))
                )->add(
                // Category
                    $select_category
                )->add(
                // Tags
                    new InputText(array(
                        'type'  => 'text',
                        'id'    => 'tags',
                        'name'  => 'tags',
                        'class' => 'form-control',
                        'label' => 'Tags',
                        'value' => $article->getTags(),
                    ))
                )->add(
                // Status
                    $select_status
                )->add(
                // Writter id.
                    new InputHidden(array(
                        'type'  => 'hidden',
                        'id'    => 'writter',
                        'name'  => 'writter',
                        'value' => $user->getId(),
                    ))
                )->add(
                    new InputHidden(array(
                        'type'  => 'hidden',
                        'id'    => 'article_id',
                        'name'  => 'article_id',
                        'value' => $services['get.handler']->getRequestField('article'),
                    ))
                )->add(
                // Summary
                    $select_summary
                )->add(
                // Submit
                    new InputSubmit(array(
                        'type'  => 'submit',
                        'id'    => 'submit',
                        'name'  => 'submit',
                        'class' => 'form-control btn btn-primary',
                        'value' => 'Submit',
                    ))
                )->getForms(),
                'user'       => $user,
                'connect'    => true,
                'article_id' => true,
                'website' => $services['dao.website']->findSettings('../app/settings.yml'),
            );
    
            return $domains;
        }
    }