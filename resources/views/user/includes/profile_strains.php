  <div id="proStrains" class="tab-pane fade">
                                        <div class="listing-area">
                                            <div class="journal-set">
                                                <a href="#" class="journal-opener yellow">My Favorite Strains</a>
                                                <ul class="journals active list-none">
                                                    <?php foreach ($user->getSavedStrain as $strain){ ?>
                                                    <li><?php echo $strain->title;?></li>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>