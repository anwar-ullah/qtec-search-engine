<div class="form-group">
  <label for="status"><strong>Status :</strong><span class="text-danger">&nbsp;*</span></label>
  <br>
  <div class="icheck-primary d-inline">
    <input type="radio" id="status-radio-1" name="status" value="1" {{ (($status=="1") ? 'checked' : '') }}>
    <label for="status-radio-1" class="text-primary">
      Active&nbsp;&nbsp;
    </label>
  </div>
  <div class="icheck-danger d-inline">
    <input type="radio" id="status-radio-0" name="status" value="0" {{ (($status=="0") ? 'checked' : '') }}>
    <label for="status-radio-0" class="text-danger">
      Inactive&nbsp;&nbsp;
    </label>
  </div>
</div>