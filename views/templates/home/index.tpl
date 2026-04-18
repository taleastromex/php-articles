{extends file="layouts/main.tpl"}

{block name="title"}Home - Blogy{/block}

{block name="content"}
    {foreach $groupedArticles as $categoryId => $articles}
        {assign var="category" value=$categoriesById[$categoryId]}

        <section class="section">
            <div class="section__header">
                <h2 class="section__title">{$category->name}</h2>
                <a href="/categories/{$category->slug}" class="btn btn--outline">All articles</a>
            </div>

            <div class="grid grid--3">
                {foreach $articles as $article}
                    {include file="partials/article-card.tpl" article=$article}
                {/foreach}
            </div>
        </section>
    {/foreach}
{/block}
