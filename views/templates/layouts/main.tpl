<!DOCTYPE html>
<html lang="{block name='lang'}en{/block}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {* ── Primary SEO ─────────────────────────────────────────────────── *}
    <title>{block name='title'}Main{/block}</title>
    <meta name="description"    content="{block name='description'}A simple articles app.{/block}">
    <meta name="keywords"       content="{block name='keywords'}{/block}">
    <meta name="author"         content="{block name='author'}Articles{/block}">
    <meta name="robots"         content="{block name='robots'}index, follow{/block}">
    <link rel="canonical"       href="{block name='canonical'}{/block}">

    {* ── Open Graph ──────────────────────────────────────────────────── *}
    <meta property="og:type"        content="{block name='og_type'}website{/block}">
    <meta property="og:url"         content="{block name='og_url'}{/block}">
    <meta property="og:title"       content="{block name='og_title'}Articles{/block}">
    <meta property="og:description" content="{block name='og_description'}A simple articles app.{/block}">
    <meta property="og:image"       content="{block name='og_image'}{/block}">
    <meta property="og:site_name"   content="{block name='og_site_name'}Articles{/block}">
    <meta property="og:locale"      content="{block name='og_locale'}en_US{/block}">

    {* ── Twitter Card ────────────────────────────────────────────────── *}
    <meta name="twitter:card"        content="{block name='tw_card'}summary_large_image{/block}">
    <meta name="twitter:title"       content="{block name='tw_title'}Articles{/block}">
    <meta name="twitter:description" content="{block name='tw_description'}A simple articles app.{/block}">
    <meta name="twitter:image"       content="{block name='tw_image'}{/block}">

    {* ── Favicon ─────────────────────────────────────────────────────── *}
    <link rel="icon"             type="image/x-icon"  href="/favicon.ico">
    <link rel="icon"             type="image/png"     sizes="32x32" href="/favicon-32x32.png">
    <link rel="apple-touch-icon"                      href="/apple-touch-icon.png">

    {* ── Styles ──────────────────────────────────────────────────────── *}
    {block name='styles'}{/block}
</head>
<body>
    {include file='./header.tpl'}

    {block name='content'}{/block}

    {* ── Scripts ─────────────────────────────────────────────────────── *}
    {block name='scripts'}{/block}

</body>
</html>
