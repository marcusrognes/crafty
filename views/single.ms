{{>parts/header/topbar-left-flyout}}

{{#post}}
    <article id="post_{{ID}}">
        <header>
            {{#image}}
                <img src="{{banner-large}}" />
            {{/image}}
            {{^image}}
                <img src="http://lorempixel.com/1024/170/cats/" />
            {{/image}}
        </header>
        <main class="row">
            <h1>
                {{post_title}}
            </h1>
            <h4>
                Posted on: {{post_date}} | By: {{author.display_name}}
            </h4>
            {{{post_content}}}
        </main>
        <footer class="row">
            <hr>
            {{>parts/content/sharing}}
        </footer>
    </article>
{{/post}}

{{>parts/footer/basic}}