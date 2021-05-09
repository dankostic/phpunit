@extends('layouts.app')

@section('content')
    <div class="top-bar">
        <div class="top-bar-left">
            <ul class="dropdown menu" data-dropdown-menu>
                <li class="menu-text"><a href="/category">Multi level categories</a></li>
                @foreach($categories as $cat)
                    <li><a href="/show-category/{{$cat->id}}">{{$cat->name}}</a></li>
                @endforeach
                {{--                <li class="has-submenu">--}}
{{--                    <a href="/show-category/1">Football</a>--}}
{{--                    <ul class="submenu menu vertical" data-submenu>--}}
{{--                        <li><a href="#">Monitors</a></li>--}}
{{--                        <li><a href="#">Tablets</a></li>--}}
{{--                        <li>--}}
{{--                            <a href="#">Computers</a>--}}
{{--                            <ul class="submenu menu vertical" data-submenu>--}}
{{--                                <li><a href="#">Desktops</a></li>--}}
{{--                                <li><a href="#">Notebooks</a></li>--}}
{{--                                <li>--}}
{{--                                    <a href="#">Laptops</a>--}}
{{--                                    <ul class="submenu menu vertical" data-submenu>--}}
{{--                                        <li><a href="#">Asus</a></li>--}}
{{--                                        <li><a href="#">Dell</a></li>--}}
{{--                                        <li>--}}
{{--                                            <a href="#">Acer</a>--}}
{{--                                            <ul class="submenu menu vertical" data-submenu>--}}
{{--                                                <li><a href="#">FullHD</a></li>--}}
{{--                                                <li><a href="#">HD+</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li><a href="#">Videos</a></li>
                <li>
                    <a href="#">Software</a>
                    <ul class="submenu menu vertical" data-submenu>
                        <li>
                            <a href="#">Operating systems</a>
                            <ul class="submenu menu vertical" data-submenu>
                                <li><a href="#">Linux</a></li>
                            </ul>
                        </li>
                        <li><a href="#">Servers</a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="top-bar-right">
            <ul class="menu">
                <li><input type="search" placeholder="Search" /></li>
                <li><button type="button" class="button">Search</button></li>
            </ul>
        </div>
    </div>
    <!-- End Top Bar -->
    <br />
    <br />
    <div class="grid-container">
        <div class="grid-x grid-margin-x">
            <div class="medium-6 cell">
                <h3>
                    <?=$edit_category ?? 'Add new category' ?>
                </h3>
                <?php if(isset($categorySaved) && $categorySaved == false): ?>
                <div class="callout alert">
                    Fill correctly the form
                </div>
                <?php endif;
                if(isset($categorySaved) && $categorySaved == true):
                ?>
                <div class="callout success">
                    Category was saved
                </div>
                <?php endif; ?>
                @if(!empty($category_deleted))
                <div class="callout alert">
                    Category was deleted
                </div>
                @endif
                <form action="/save-category" method="POST">
                    @csrf
                <label
                >Name
                    <input type="text" placeholder="Name" name="name" value="<?= $category->name ?? null ?>" />
                </label>
                <label
                >Description
                    <textarea placeholder="Description" name="description">
                        <?= $category->description ?? null ?>
                    </textarea>
                </label>
                <label
                >Parent category
                    <select id="selected-category-list">
                        <option>--choose--</option>
                        @if(isset($edit_category))
                        @foreach($select_categories as $sc)
                            <option selected value="{{$sc->id}}">{{$sc->name}}</option>
                        @endforeach
                        @else
                            @foreach($select_categories as $sc)
                                <option value="{{$sc->id}}">{{$sc->name}}</option>
                            @endforeach
                        @endif
                    </select>
                </label>
                <input
                    type="submit"
                    class="button expanded"
                    value="Save category"
                />
                    @if(isset($edit_category))
                    <input type="hidden" name="category_id" value="<?=$category->id ?>">
                    @endif
                </form>
            </div>

            <div class="medium-6 large-5 cell large-offset-1">
                <div class="basic-card">
                    <div class="basic-card-content content callout secondary">
                        <h5><?= $category->name ?? "Computer"?></h5>
                        <p>
                            <?= $category->description ?? "Computer description of category"?>
                        </p>
                    </div>
                    <div class="links callout primary">
                        <ul class="menu">
                            <li>
                                <a href="/edit-category/1">Edit</a>
                            </li>
                            <li>
                                <a href="/delete-category/1" id="delete-category-confirmation" onclick="return confirm('Are you sure?')">Delete</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <hr />
    </div>

@endsection
<script src="{{ asset('js/what-input.js') }}"></script>
<script src="{{ asset('js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ asset('js/foundation.min.js') }}"></script>
<script>
    $(document).foundation();
</script>
