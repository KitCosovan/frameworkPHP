<section class="content">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $title ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="<?= base_url('/') ?>">Home</a></li>
                        <li class="breadcrumb-item active">Post</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Edit post</h3>
            </div>


            <form method="post" action="<?= base_url('/admin/posts/update'); ?>" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control <?= get_validation_class('title', $errors ?? []); ?>" name="title" id="title" placeholder="Enter your title" value="<?= html($post['title']); ?>">
                                <?= get_errors('title', $errors ?? []); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control <?= get_validation_class('slug', $errors ?? []); ?>" name="slug" id="slug" placeholder="Enter your slug" value="<?= html($post['slug']); ?>">
                                <?= get_errors('slug', $errors ?? []); ?>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Category</label>
                                <select name="category_id" id="category_id" class="form-control <?= get_validation_class('category_id', $errors ?? []); ?>">
                                    <?php foreach ($categories as $category) : ?>
                                        <option value="<?= $category['id']; ?>" <?= selected('form_data', 'category_id', $category['id'], $post); ?>><?= $category['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Select Tags</label>
                                <select multiple name="tag_id[]" id="tag_id" class="form-control select2">
                                    <?php foreach ($tags as $tag) : ?>
                                        <option value="<?= $tag['id']; ?>" <?= selected('form_data', 'tag', $tag['id'], $post); ?>><?= $tag['title']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="excerpt">Excerpt</label>
                        <input type="text" class="form-control <?= get_validation_class('excerpt', $errors ?? []); ?>" name="excerpt" id="excerpt" placeholder="Enter your excerpt" value="<?= html($post['excerpt']); ?>">
                        <?= get_errors('excerpt', $errors ?? []); ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <p class="text-info text-bold">Upload a picture if you want to change it.</p>
                        </div>
                        <div class="col-md-2">
                            <img src="<?= $post['image']; ?>" alt="" class="img-thumbnail">
                        </div>

                        <div class="col-md-10">
                            <div class="form-group">
                                <label for="image">Image</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="image" class="custom-file-input <?= get_validation_class('image', $errors ?? []); ?>" id="image">
                                        <label class="custom-file-label" for="image">Choose file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <span class="input-group-text">Upload</span>
                                    </div>
                                    <?= get_errors('image', $errors ?? []); ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea id="content" name="content" class="form-control summernote <?= get_validation_class('content', $errors ?? []); ?>" rows="3" placeholder="Content"><?= html($post['content']); ?></textarea>
                        <?= get_errors('content', $errors ?? []); ?>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="hidden" name="id" value="<?= $post['id']; ?>">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <?php
            session()->forget('form_errors');
            ?>
        </div>

    </section>
    <!-- /.content -->
</section>