<template>
    <div id="app">
        <div>
            <!--========== ADMIN SIDE MENU one ========-->
            <div class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align: center">Logo Image</h3>
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li>
                                <router-link to="/home"><a>
                                        <Icon type="ios-speedometer" />Dashboard
                                    </a></router-link>
                            </li>
                            <li>
                                <router-link to="/tags"><a>
                                        <Icon type="ios-speedometer" /> Tags
                                    </a></router-link>
                            </li>
                            <li>
                                <router-link to="/category"><a>
                                        <Icon type="ios-speedometer" /> Category
                                    </a></router-link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <!--========= HEADER ==========-->
        </div>
        <router-view></router-view>
    </div>
</template>
