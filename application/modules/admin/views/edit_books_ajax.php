<form id="edit_books_form">
    <input type="hidden" class="form-control" value="<?php echo $book['id']; ?>" placeholder="id" name="id">
    <div class="form-group row">
        <label class="col-md-3 col-form-label">University</label>
        <div class="col-md-9">
            <input type="text" class="form-control" value="<?php echo $book['university']; ?>" placeholder="University" name="university">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Field Of Study</label>
        <div class="col-md-9">
            <input type="text" class="form-control" value="<?php echo $book['field_of_study']; ?>" placeholder="Field Of Study" name="field_of_study">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Full Time Semester</label>
        <div class="col-md-9">
            <input type="number" min="1" class="form-control" value="<?php echo $book['full_time_semester']; ?>" placeholder="Full Time Semester" name="full_time_semester">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Part Time Semester</label>
        <div class="col-md-9">
            <input type="number" min="1" class="form-control" value="<?php echo $book['part_time_semester']; ?>" placeholder="Part Time Semester" name="part_time_semester">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Module</label>
        <div class="col-md-9">
            <input type="text" class="form-control" value="<?php echo $book['module']; ?>" placeholder="Module" name="module">
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Price</label>
        <div class="col-md-9">
            <div class="input-group">
                <span class="input-group-addon">CHF</span>
                <input type="text" class="form-control" value="<?php echo $book['price']; ?>" placeholder="Price" name="price" required>
            </div>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">ISBN</label>
        <div class="col-md-9">
            <input type="text" class="form-control" value="<?php echo $book['ISBN']; ?>" placeholder="ISBN" name="ISBN" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Book Name</label>
        <div class="col-md-9">
            <textarea class="form-control" placeholder="Book Name" name="book_name" required><?php echo $book['book_name']; ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Extra Information</label>
        <div class="col-md-9">
            <textarea class="form-control" placeholder="Extra Information" name="extra_information"><?php echo $book['extra_information']; ?></textarea>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Mandatory</label>
        <div class="col-md-9">
            <div class="form-radio">
                <div class="radio radio-inline">
                    <label>
                        <input type="radio" name="mandatory_or_optional" <?php if($book['mandatory_or_optional'] == 0){ ?> checked="checked" <?php } ?> value="0">
                        <i class="helper"></i>Yes
                    </label>
                </div>
                <div class="radio radio-inline">
                    <label>
                        <input type="radio" name="mandatory_or_optional" <?php if($book['mandatory_or_optional'] == 1){ ?> checked="checked" <?php } ?>  value="1">
                        <i class="helper"></i>No
                    </label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-md-3 col-form-label">Only Used</label>
        <div class="col-md-9">
            <div class="checkbox-fade fade-in-primary">
                <label>
                    <input type="checkbox" name="only_used" <?php if ($book['only_used'] == 1) { ?> checked <?php } ?>>
                    <span class="cr">
                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                    </span> <span>Yes</span>
                </label>
            </div>
        </div>
    </div>
</form>
