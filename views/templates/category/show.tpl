{extends file="layouts/main.tpl"}

{block name="title"}{$category->name} — Blogy{/block}
{block name="description"}{$category->description}{/block}

{block name="content"}
    <section class="section">
        <div class="section__header">
            <div>
                <h1 class="section__title">{$category->name}</h1>
                {if $category->description}
                    <p>{$category->description}</p>
                {/if}
            </div>

            <div>
                <a href="?sort=created_at" class="btn {if $sort === 'created_at'}btn--primary{else}btn--outline{/if}">
                    By date
                </a>
                <a href="?sort=views" class="btn {if $sort === 'views'}btn--primary{else}btn--outline{/if}">
                    By views
                </a>
            </div>
        </div>

        <div class="grid grid--3">
            {foreach $articles as $article}
                {include file="partials/article-card.tpl" article=$article}
            {/foreach}
        </div>

        {if $paginator->hasPages()}
            <nav class="pagination">
                <div class="pagination__item {if !$paginator->hasPrev()}pagination__item--disabled{/if}">
                    {if $paginator->hasPrev()}
                        <a href="?page={$paginator->currentPage - 1}&sort={$sort}">&larr;</a>
                    {else}
                        <span>&larr;</span>
                    {/if}
                </div>

                {for $page = 1 to $paginator->totalPages}
                    <div class="pagination__item {if $page === $paginator->currentPage}pagination__item--active{/if}">
                        {if $page === $paginator->currentPage}
                            <span>{$page}</span>
                        {else}
                            <a href="?page={$page}&sort={$sort}">{$page}</a>
                        {/if}
                    </div>
                {/for}

                <div class="pagination__item {if !$paginator->hasNext()}pagination__item--disabled{/if}">
                    {if $paginator->hasNext()}
                        <a href="?page={$paginator->currentPage + 1}&sort={$sort}">&rarr;</a>
                    {else}
                        <span>&rarr;</span>
                    {/if}
                </div>
            </nav>
        {/if}
    </section>
{/block}
