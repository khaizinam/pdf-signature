<?php

namespace Dev\Member\Forms;

use Dev\Base\Forms\FieldOptions\TagFieldOption;
use Dev\Base\Forms\FieldOptions\TextareaFieldOption;
use Dev\Base\Forms\Fields\TagField;
use Dev\Blog\Forms\PostForm as BasePostForm;
use Dev\Blog\Models\Post;
use Dev\Blog\Models\Tag;
use Dev\Member\Forms\Fields\CustomEditorField;
use Dev\Member\Http\Requests\PostRequest;

class PostForm extends BasePostForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->model(Post::class)
            ->setFormOption('template', 'plugins/member::forms.base')
            ->hasFiles()
            ->setValidatorClass(PostRequest::class)
            ->setBreakFieldPoint('categories[]')
            ->remove('status')
            ->remove('is_featured')
            ->remove('content')
            ->addAfter(
                'description',
                'content',
                CustomEditorField::class,
                TextareaFieldOption::make()->label(trans('core/base::forms.content'))->rows(4)->toArray()
            )
            ->modify(
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
                            ->value(
                                $post->tags()
                                    ->select('name')
                                    ->get()
                                    ->map(fn (Tag $item) => $item->name)
                                    ->implode(',')
                            );
                    })
                    ->placeholder(trans('plugins/blog::base.write_some_tags'))
                    ->ajaxUrl(route('public.member.tags.all'))
                    ->toArray(),
                true
            );
    }
}
