<article id="post_{{ID}}">
    <h1 class="page-title">
        <a href="{{guid}}">
        {{post_title}}
        </a>
    </h1>

    {{#author}}
        <h3>By: {{display_name}}</h3>
    {{/author}}

    {{#image}}
        <img src="{{full}}" />
    {{/image}}

    <div class="page-content">
        {{{post_content}}}
    </div>
</article>