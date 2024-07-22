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
                        <li class="breadcrumb-item active">Category</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">New category</h3>
            </div>


            <form method="post" action="<?= base_url('/admin/categories/store'); ?>" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control <?= get_validation_class('title', $errors ?? []); ?>" name="title" id="title" placeholder="Enter your title" value="<?= oldfFromSession('form_data', 'title'); ?>">
                                <?= get_errors('title', $errors ?? []); ?>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="slug">Slug</label>
                                <input type="text" class="form-control slug <?= get_validation_class('slug', $errors ?? []); ?>" name="slug" id="slug" placeholder="Enter your slug" value="<?= oldfFromSession('form_data', 'slug'); ?>">
                                <?= get_errors('slug', $errors ?? []); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>

            <?php
                session()->forget('form_data');
                session()->forget('form_errors');
            ?>
        </div>

    </section>
    <!-- /.content -->
</section>