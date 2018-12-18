<header id="header">
    <ul class="list-none">
        <div class="sort-dropdown journ-header">
            <div class="form-holder">
                <form action="#">
                    <fieldset>
                        <select>
                            <option>Sort Q's By</option>
                        </select>
                    </fieldset>
                </form>
                <a href="#" class="options-toggler opener"><i class="fa fa-caret-down" aria-hidden="true"></i></a>
            </div>
            <div class="options">
                <ul class="list-none">
                    <li>
                        <img src="<?php echo asset('userassets/images/heart-icon.png') ?>" alt="Favorites">
                        <span>Favorites</span>
                    </li>
                    <li>
                        <img src="<?php echo asset('userassets/images/new-icon.png') ?>" alt="Newest">
                        <span>Newest</span>
                    </li>
                    <li>
                        <img src="<?php echo asset('userassets/images/question-icon2.png') ?>" alt="Unanswered">
                        <span>Unanswered</span>
                    </li>
                    <li>
                        <img src="<?php echo asset('userassets/images/question-icon.svg') ?>" alt="Unanswered">
                        <span>My Questions</span>
                    </li>
                    <li>
                        <img src="<?php echo asset('userassets/images/answer-icon.svg') ?>" alt="My Answers">
                        <span>My Answers</span>
                    </li>
                </ul>
                <a href="#" class="options-toggler closer"><i class="fa fa-caret-up" aria-hidden="true"></i></a>
            </div>
        </div>
    </ul>
    <a href="#" class="side-opener">Opener</a>
</header>