<?php

namespace Dev\Kernel\Providers;

use MetaBox;
use Illuminate\Support\Arr;
use Dev\Page\Models\Page;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Dev\ACL\Models\User;
use Dev\ACL\Repositories\Interfaces\ActivationInterface;
use Dev\Multisite\Repositories\Interfaces\MultisiteInterface;
use Dev\PagesPedding\Models\PagesPedding;

class HookServiceProvider extends ServiceProvider
{
    public function boot()
    {
        add_filter(BASE_FILTER_FOOTER_LAYOUT_TEMPLATE, function ($payload) {
            return $payload . "<script>
            setTimeout(() => {
                [...document.querySelectorAll('.col-md-9 .widget.meta-boxes .widget-body')].forEach(el => el.classList.add('d-none'));
                [...document.querySelectorAll('.col-md-9 .widget.meta-boxes .widget-title')].forEach(el => {
                    el.style.cursor = 'pointer';
                    el.style.position = 'relative';
                    let nodeI = document.createElement('i');
                    nodeI.classList.add('fa', 'fa-caret-down')
                    nodeI.style.position = 'absolute';
                    nodeI.style.top = '50%';
                    nodeI.style.right = '.7rem';
                    nodeI.style.transform = 'translateY(-50%)';
                    el.appendChild(nodeI)
                });
                [...document.querySelectorAll('.col-md-9 .widget.meta-boxes .widget-title')].forEach(el => el.addEventListener('click', function() {
                    if(this.parentElement.querySelector('.widget-body').classList.contains('d-none')) {
                        this.querySelector('i.fa').classList.add('fa-caret-up')
                        this.querySelector('i.fa').classList.remove('fa-caret-down')
                    } else {
                        this.querySelector('i.fa').classList.add('fa-caret-down')
                        this.querySelector('i.fa').classList.remove('fa-caret-up')
                    }
                    this.parentElement.querySelector('.widget-body').classList.toggle('d-none')
                }))
            }, 1000)

            </script>";
        }, 20, 1);
    }
}
