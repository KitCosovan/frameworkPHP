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
                        <li class="breadcrumb-item active">Posts</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Posts Table</h3>
                            <div class="card-tools d-flex flex-row mb-3 justify-content-between align-items-center" style="width: 200px;">
                                <div class="input-group input-group-sm" style="width: 150px;">
                                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <a href="<?= base_url('/admin/posts/create'); ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Add new post"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>

                        <?php if (!empty($posts)) : ?>
                            <div class="card-body table-responsive p-0">
                                <table class="table table-hover text-nowrap">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Title</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <?php foreach ($posts as $post) : ?>
                                        <tbody>
                                            <tr>
                                                <td><?= $post['id']; ?></td>
                                                <td><?= $post['title']; ?></td>
                                                <td><?= $post['created_at']; ?></td>
                                                <td>
                                                    <a href="<?= base_url("/admin/posts/edit?id={$post['id']}"); ?>" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Edit post"><i class="fas fa-edit"></i></a>
                                                    <a href="<?= base_url("/admin/posts/delete?id={$post['id']}"); ?>" class="btn btn-danger del-item" data-toggle="tooltip" data-placement="top" title="Delete post"><i class="fas fa-trash"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        <?php else : ?>
                            <p class="p-3">Not found posts...</p>
                        <?php endif; ?>

                        <div class="card-footer clearfix">
                            <?php if ($pagination->count_pages > 1) : ?>
                                <ul class="pagination pagination-sm float-right">
                                    <?= $pagination; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </section>
    <!-- /.content -->
</section>