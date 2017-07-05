---
title: Posts
creator: admin
taxonomy:
    category:
        - blog
markdown:
    escape_markup: false
content:
    items: '@self.children'
    limit: 3
    order:
        by: date
        dir: desc
    pagination: '1'
    url_taxonomy_filters: '1'
simplesearch:
    route: '@self'
    filters:
        - '@self'
---

<h2>BLOG</h2>