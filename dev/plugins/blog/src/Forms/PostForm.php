<?php

namespace Dev\Blog\Forms;

use Dev\Base\Forms\FieldOptions\ContentFieldOption;
use Dev\Base\Forms\FieldOptions\DescriptionFieldOption;
use Dev\Base\Forms\FieldOptions\IsFeaturedFieldOption;
use Dev\Base\Forms\FieldOptions\NameFieldOption;
use Dev\Base\Forms\FieldOptions\RadioFieldOption;
use Dev\Base\Forms\FieldOptions\SelectFieldOption;
use Dev\Base\Forms\FieldOptions\StatusFieldOption;
use Dev\Base\Forms\FieldOptions\TagFieldOption;
use Dev\Base\Forms\Fields\EditorField;
use Dev\Base\Forms\Fields\MediaImageField;
use Dev\Base\Forms\Fields\OnOffField;
use Dev\Base\Forms\Fields\RadioField;
use Dev\Base\Forms\Fields\SelectField;
use Dev\Base\Forms\Fields\TagField;
use Dev\Base\Forms\Fields\TextareaField;
use Dev\Base\Forms\Fields\TextField;
use Dev\Base\Forms\Fields\TreeCategoryField;
use Dev\Base\Forms\FormAbstract;
use Dev\Blog\Http\Requests\PostRequest;
use Dev\Blog\Models\Category;
use Dev\Blog\Models\Post;
use Dev\Blog\Models\Tag;

class PostForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Post::class)
            ->setValidatorClass(PostRequest::class)
            ->hasTabs()
            ->add('name', TextField::class, NameFieldOption::make()->required()->toArray())
            ->add('description', TextareaField::class, DescriptionFieldOption::make()->toArray())
            ->add(
                'is_featured',
                OnOffField::class,
                IsFeaturedFieldOption::make()
                    ->toArray()
            )
            ->add('content', EditorField::class, ContentFieldOption::make()->allowedShortcodes()->toArray())
            ->add('status', SelectField::class, StatusFieldOption::make()->toArray())
            ->when(get_post_formats(true), function (PostForm $form, array $postFormats) {
                if (count($postFormats) > 1) {
                    $choices = [];

                    foreach ($postFormats as $postFormat) {
                        $choices[$postFormat[0]] = $postFormat[1];
                    }

                    $form
                        ->add(
                            'format_type',
                            RadioField::class,
                            RadioFieldOption::make()
                                ->label(trans('plugins/blog::posts.form.format_type'))
                                ->choices($choices)
                                ->toArray()
                        );
                }
            })
            ->add(
                'categories[]',
                TreeCategoryField::class,
                SelectFieldOption::make()
                    ->label(trans('plugins/blog::posts.form.categories'))
                    ->choices(get_categories_with_children())
                    ->when($this->getModel()->getKey(), function (SelectFieldOption $fieldOption) {
                        /**
                         * @var Post $post
                         */
                        $post = $this->getModel();

                        return $fieldOption->selected($post->categories()->pluck('category_id')->all());
                    }, function (SelectFieldOption $fieldOption) {
                        return $fieldOption
                            ->selected(
                                Category::query()
                                    ->where('is_default', 1)
                                    ->pluck('id')
                                    ->all()
                            );
                    })
                    ->toArray()
            )
            ->add('image', MediaImageField::class)
            ->add(
                'tag',
                TagField::class,
                TagFieldOption::make()
                    ->label(trans('plugins/blog::posts.form.tags'))
                    ->when($this->getModel()->getKey(), function (TagFieldOption $fieldOption) {
                        /**
                         * @var Post $post
                         */
                        $post = $this->getModel();

                        return $fieldOption
                            ->selected(
                                $post
                                    ->tags()
                                    ->select('name')
                                    ->get()
                                    ->map(fn (Tag $item) => $item->name)
                                    ->implode(',')
                            );
                    })
                    ->placeholder(trans('plugins/blog::base.write_some_tags'))
                    ->ajaxUrl(route('tags.all'))
                    ->toArray()
            )
            ->setBreakFieldPoint('status');
    }
}
