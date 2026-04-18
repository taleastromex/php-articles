{extends file="layouts/main.tpl"}

{block name="title"}{$article->title} — Blogy{/block}
{block name="description"}{$article->description}{/block}
{block name="og_type"}article{/block}

{block name="content"}
    <article>
        {if $article->image}
            <img class="card__image" src="{$article->image}" alt="{$article->title}"
                 style="border-radius: 0.5rem; margin-bottom: 1.5rem;">
        {/if}

        <div style="margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap;">
            {foreach $article->categories as $category}
                <a href="/categories/{$category->slug}" class="btn btn--outline">{$category->name}</a>
            {/foreach}
        </div>

        <h1 class="section__title" style="margin-bottom: 0.5rem;">{$article->title}</h1>

        <div style="display: flex; gap: 1rem; color: #6b7280; font-size: 0.875rem; margin-bottom: 2rem;">
            <span>{$article->createdAt|date_format:'%d %b %Y'}</span>
            <span>👁 {$article->views} views</span>
        </div>

        <div style="line-height: 1.8; margin-bottom: 3rem;">
            {$article->content}
        </div>
    </article>

    {if $similar|@count > 0}
        <section class="section">
            <div class="section__header">
                <h2 class="section__title">Similar articles</h2>
            </div>
            <div class="grid grid--3">
                {foreach $similar as $item}
                    {include file="partials/article-card.tpl" article=$item}
                {/foreach}
            </div>
        </section>
    {/if}
{/block}
