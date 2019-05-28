<div class="col-xs-12 col-sm-6">
    <div class="group-member rounded" onclick="window.location ='<?="../user/user.php?u=".$user["user"]->GetId()?>'" style="height:220px;">
        <div class="group-member-profile text-center">
            <?php if(is_null($user["photo"])):?>
                <img src="../photos/static/user-default.png" class="rounded-circle" alt="" style="background-color: #009afe" >
            <?php else: ?>
                <img src="../photos/u_photos/<?= $user["photo"]->GetPath() ?>" class="rounded-circle">
            <?php endif; ?>
        </div>
        <div class="group-member-name">
            <?= $user["user"]->GetNickname() ? $user["user"]->GetNickname() : $user["user"]->GetName() ?>
        </div>
        <ul class="text-center">
            <li>
                <a class="btn-accept-user" id="<?=$user["user"]->GetId()?>"> <i class="fas fa-check-circle"></i></a>
            </li>
            <li>
                <a class="btn-deny-user" id="<?=$user["user"]->GetId()?>"><i class="fas fa-times-circle"></i></a>
            </li>
        </ul>

    </div>


</div>