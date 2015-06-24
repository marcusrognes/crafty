<div class="basic-slider">
    <ul>
        {{#slider}}
            <li>
                {{#image}}
                    <img src="{{banner-large}}"/>
                {{/image}}
                <h2>
                    <a href="{{the_permalink}}">
                        {{post_title}}
                    </a>
                </h2>
            </li>
        {{/slider}}
    </ul>
</div>