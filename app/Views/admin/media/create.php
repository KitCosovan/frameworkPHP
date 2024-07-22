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
                        <li class="breadcrumb-item active">Media</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">New media</h3>
            </div>


            <form method="post" action="<?= base_url('/admin/media/store'); ?>" enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control <?= get_validation_class('title', $errors ?? []); ?>" name="title" id="title" placeholder="Enter your title" value="<?= oldfFromSession('form_data', 'title'); ?>">
                        <?= get_errors('title', $errors ?? []); ?>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Main image</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input <?= get_validation_class('image', $errors ?? []); ?>" name="image" id="image" name="image">
                                <label class="custom-file-label" for="image">Choose file</label>
                                <?= get_errors('image', $errors ?? []); ?>
                            </div>
                            <div class="input-group-append">
                                <span class="input-group-text">Upload</span>
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