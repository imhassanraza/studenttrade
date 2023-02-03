<form id="edit_discount_codes_form">
    <input type="hidden" class="form-control" value="<?php echo $code['id'];?>" name="id">
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Discount code</label>
        <div class="col-md-9">
            <input type="text" class="form-control" placeholder="Discount Code" name="code" value="<?php echo $code['code'];?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Discount type</label>
        <div class="col-md-9">
            <select class="form-control" name="code_type">
                <option value="1" <?php if ($code['code_type'] == 1) { ?> selected <?php } ?>>Fixed Value</option>
                <option value="2" <?php if ($code['code_type'] == 2) { ?> selected <?php } ?>>Percentage</option>
            </select>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Code value</label>
        <div class="col-md-9">
            <input type="text" class="form-control" placeholder="Code Value" name="code_value" value="<?php echo $code['code_value'];?>" required>
        </div>
    </div>
    <div class="form-group row">
        <label class="col-md-3 col-form-label">Valid From To</label>
        <div class="col-md-9">
            <input type="text" name="daterange" class="form-control daterange" value="<?php echo date("m/d/Y", strtotime($code['valid_from'])); ?> - <?php echo date("m/d/Y", strtotime($code['valid_to'])); ?>" />
        </div>
    </div>
</form>
<script type="text/javascript">
    $( ".daterange").daterangepicker();
</script>