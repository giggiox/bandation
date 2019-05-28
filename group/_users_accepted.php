<div class="col-xs-12 col-sm-6">
    <div class="group-member rounded" onclick="window.location ='<?="../user/user.php?u=".$user["user"]->GetId()?>'">
        <div class="group-member-profile text-center">
            <?php if (is_null($user["photo"])): ?>
                <img src="../photos/static/user-default.png" class="rounded-circle" alt="" style="background-color: #009afe" >
            <?php else: ?>
                <img src="../photos/u_photos/<?= $user["photo"]->GetPath() ?>" class="rounded-circle">
            <?php endif; ?>
        </div>
        <div class="group-member-name">
            <?= $user["user"]->GetNickname() ? $user["user"]->GetNickname() : $user["user"]->GetName() ?>
        </div>
    </div>


</div>
