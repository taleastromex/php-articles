<article class="card">
    {if $article->image}
        <img class="card__image" src="{$article->image}" alt="{$article->title}">
    {else}
        <div class="card__image-placeholder">No image</div>
    {/if}

    <div class="card__body">
        {if $article->categories|@count > 0}
            <div class="card__categories">
                {foreach $article->categories as $cat}
                    <a href="/categories/{$cat->slug}" class="card__category">{$cat->name}</a>
                {/foreach}
            </div>
        {/if}

        <h3 class="card__title">
            <a href="/articles/{$article->slug}">{$article->title}</a>
        </h3>

        <p class="card__description">{$article->description}</p>

        <div class="card__footer">
            <span>{$article->createdAt|date_format:'%d %b %Y'}</span>
            <span class="card__views">👁 {$article->views}</span>
        </div>
    </div>
</article>
