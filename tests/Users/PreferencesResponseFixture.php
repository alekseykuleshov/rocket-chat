<?php

namespace Users;

class PreferencesResponseFixture1 extends \stdClass
{
    public function __construct()
    {
        $this->newRoomNotification = 'notification';
        $this->newMessageNotification = 'message notification';
        $this->useEmojis = true;
        $this->convertAsciiEmoji = false;
        $this->saveMobileBandwidth = false;
        $this->collapseMediaByDefault = true;
        $this->autoImageLoad = false;
        $this->emailNotificationMode = 'notification';
        $this->roomsListExhibitionMode = 'exhibition';
        $this->unreadAlert = true;
        $this->notificationsSoundVolume = 50;
        $this->desktopNotifications = 'desktop notifications';
        $this->mobileNotifications = 'mobile notifications';
        $this->enableAutoAway = false;
        $this->highlights = ['test highlight'];
        $this->desktopNotificationDuration = 100;
        $this->desktopNotificationRequireInteraction = false;
        $this->viewMode = 0;
        $this->hideUsernames = false;
        $this->hideRoles = false;
        $this->hideAvatars = false;
        $this->sendOnEnter = 'message';
        $this->roomCounterSidebar = false;
        $this->language = 'pt-BR';
    }
}

class PreferencesResponseFixture2 extends \stdClass
{
    public function __construct()
    {
        $this->sidebarShowFavorites = false;
        $this->sidebarShowUnread = true;
        $this->sidebarSortby = 'sort ';
        $this->sidebarViewMode = 'view mode';
        $this->sidebarHideAvatar = false;
        $this->groupByType = true;
        $this->muteFocusedConversations = true;
    }
}

class PreferencesResponseFixtureFull extends \stdClass
{
    public function __construct()
    {
        foreach ([new PreferencesResponseFixture1(), new PreferencesResponseFixture2()] as $fixture) {
            foreach ($fixture as $key => $value) {
                $this->{$key} = $value;
            }
        }
    }
}
