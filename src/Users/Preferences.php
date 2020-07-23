<?php

namespace ATDev\RocketChat\Users;

class Preferences
{
    // Required properties
    /** @var string New room notification */
    private $newRoomNotification;
    /** @var string New message notification */
    private $newMessageNotification;
    /** @var bool User can use emojis */
    private $useEmojis;
    /** @var bool Convert ascII emojis */
    private $convertAsciiEmoji;
    /** @var bool Save mobile bandwidth */
    private $saveMobileBandwidth;
    /** @var bool Collapse media by default */
    private $collapseMediaByDefault;
    /** @var bool Image load automatically */
    private $autoImageLoad;
    /** @var string Email notification mode */
    private $emailNotificationMode;
    /** @var string Rooms list exhibition mode */
    private $roomsListExhibitionMode;
    /** @var bool Unread Alert */
    private $unreadAlert;
    /** @var int Volume of notification sound */
    private $notificationsSoundVolume;
    /** @var string Desktop notifications */
    private $desktopNotifications;
    /** @var string Mobile notifications */
    private $mobileNotifications;
    /** @var bool Enable auto away */
    private $enableAutoAway;
    /** @var array Highlights */
    private $highlights;
    /** @var int Duration of desktop notification */
    private $desktopNotificationDuration;
    /** @var bool Determines if user has to click on desktop notification to close it (requires Google Chrome version > 50 as client, overwrites setting desktopNotificationDuration) */
    private $desktopNotificationRequireInteraction;
    /** @var int View mode */
    private $viewMode;
    /** @var bool Hide usernames */
    private $hideUsernames;
    /** @var bool Hide user roles */
    private $hideRoles;
    /** @var bool Hide avatars */
    private $hideAvatars;
    /** @var string Send message on enter */
    private $sendOnEnter;
    /** @var bool Display room counter on sidebar */
    private $roomCounterSidebar;
    /** @var string Language */
    private $language;

    // Optional parameters
    /** @var bool Show favorites on sidebar */
    private $sidebarShowFavorites;
    /** @var bool Show unread on sidebar */
    private $sidebarShowUnread;
    /** @var string Show sort by */
    private $sidebarSortby;
    /** @var string Show view mode */
    private $sidebarViewMode;
    /** @var bool Show avatar on hide bar */
    private $sidebarHideAvatar;
    /** @var bool Group channels by type */
    private $groupByType;
    /** @var bool Mute focused conversations */
    private $muteFocusedConversations;

    public static function createOutOfResponse($response)
    {
        $preferences = new static();

        if (isset($response->createdAt)) {
            $this->setCreatedAt($response->createdAt);
        }

        return $preferences;
    }

    public function 

    /**
     * @return string
     */
    public function getNewRoomNotification(): string
    {
        return $this->newRoomNotification;
    }

    /**
     * @param string $newRoomNotification
     * @return Preferences
     */
    public function setNewRoomNotification(string $newRoomNotification): Preferences
    {
        $this->newRoomNotification = $newRoomNotification;
        return $this;
    }

    /**
     * @return string
     */
    public function getNewMessageNotification(): string
    {
        return $this->newMessageNotification;
    }

    /**
     * @param string $newMessageNotification
     * @return Preferences
     */
    public function setNewMessageNotification(string $newMessageNotification): Preferences
    {
        $this->newMessageNotification = $newMessageNotification;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUseEmojis(): bool
    {
        return $this->useEmojis;
    }

    /**
     * @param bool $useEmojis
     * @return Preferences
     */
    public function setUseEmojis(bool $useEmojis): Preferences
    {
        $this->useEmojis = $useEmojis;
        return $this;
    }

    /**
     * @return bool
     */
    public function isConvertAsciiEmoji(): bool
    {
        return $this->convertAsciiEmoji;
    }

    /**
     * @param bool $convertAsciiEmoji
     * @return Preferences
     */
    public function setConvertAsciiEmoji(bool $convertAsciiEmoji): Preferences
    {
        $this->convertAsciiEmoji = $convertAsciiEmoji;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSaveMobileBandwidth(): bool
    {
        return $this->saveMobileBandwidth;
    }

    /**
     * @param bool $saveMobileBandwidth
     * @return Preferences
     */
    public function setSaveMobileBandwidth(bool $saveMobileBandwidth): Preferences
    {
        $this->saveMobileBandwidth = $saveMobileBandwidth;
        return $this;
    }

    /**
     * @return bool
     */
    public function isCollapseMediaByDefault(): bool
    {
        return $this->collapseMediaByDefault;
    }

    /**
     * @param bool $collapseMediaByDefault
     * @return Preferences
     */
    public function setCollapseMediaByDefault(bool $collapseMediaByDefault): Preferences
    {
        $this->collapseMediaByDefault = $collapseMediaByDefault;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoImageLoad(): bool
    {
        return $this->autoImageLoad;
    }

    /**
     * @param bool $autoImageLoad
     * @return Preferences
     */
    public function setAutoImageLoad(bool $autoImageLoad): Preferences
    {
        $this->autoImageLoad = $autoImageLoad;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailNotificationMode(): string
    {
        return $this->emailNotificationMode;
    }

    /**
     * @param string $emailNotificationMode
     * @return Preferences
     */
    public function setEmailNotificationMode(string $emailNotificationMode): Preferences
    {
        $this->emailNotificationMode = $emailNotificationMode;
        return $this;
    }

    /**
     * @return string
     */
    public function getRoomsListExhibitionMode(): string
    {
        return $this->roomsListExhibitionMode;
    }

    /**
     * @param string $roomsListExhibitionMode
     * @return Preferences
     */
    public function setRoomsListExhibitionMode(string $roomsListExhibitionMode): Preferences
    {
        $this->roomsListExhibitionMode = $roomsListExhibitionMode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUnreadAlert(): bool
    {
        return $this->unreadAlert;
    }

    /**
     * @param bool $unreadAlert
     * @return Preferences
     */
    public function setUnreadAlert(bool $unreadAlert): Preferences
    {
        $this->unreadAlert = $unreadAlert;
        return $this;
    }

    /**
     * @return int
     */
    public function getNotificationsSoundVolume(): int
    {
        return $this->notificationsSoundVolume;
    }

    /**
     * @param int $notificationsSoundVolume
     * @return Preferences
     */
    public function setNotificationsSoundVolume(int $notificationsSoundVolume): Preferences
    {
        $this->notificationsSoundVolume = $notificationsSoundVolume;
        return $this;
    }

    /**
     * @return string
     */
    public function getDesktopNotifications(): string
    {
        return $this->desktopNotifications;
    }

    /**
     * @param string $desktopNotifications
     * @return Preferences
     */
    public function setDesktopNotifications(string $desktopNotifications): Preferences
    {
        $this->desktopNotifications = $desktopNotifications;
        return $this;
    }

    /**
     * @return string
     */
    public function getMobileNotifications(): string
    {
        return $this->mobileNotifications;
    }

    /**
     * @param string $mobileNotifications
     * @return Preferences
     */
    public function setMobileNotifications(string $mobileNotifications): Preferences
    {
        $this->mobileNotifications = $mobileNotifications;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableAutoAway(): bool
    {
        return $this->enableAutoAway;
    }

    /**
     * @param bool $enableAutoAway
     * @return Preferences
     */
    public function setEnableAutoAway(bool $enableAutoAway): Preferences
    {
        $this->enableAutoAway = $enableAutoAway;
        return $this;
    }

    /**
     * @return array
     */
    public function getHighlights(): array
    {
        return $this->highlights;
    }

    /**
     * @param array $highlights
     * @return Preferences
     */
    public function setHighlights(array $highlights): Preferences
    {
        $this->highlights = $highlights;
        return $this;
    }

    /**
     * @return int
     */
    public function getDesktopNotificationDuration(): int
    {
        return $this->desktopNotificationDuration;
    }

    /**
     * @param int $desktopNotificationDuration
     * @return Preferences
     */
    public function setDesktopNotificationDuration(int $desktopNotificationDuration): Preferences
    {
        $this->desktopNotificationDuration = $desktopNotificationDuration;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDesktopNotificationRequireInteraction(): bool
    {
        return $this->desktopNotificationRequireInteraction;
    }

    /**
     * @param bool $desktopNotificationRequireInteraction
     * @return Preferences
     */
    public function setDesktopNotificationRequireInteraction(bool $desktopNotificationRequireInteraction): Preferences
    {
        $this->desktopNotificationRequireInteraction = $desktopNotificationRequireInteraction;
        return $this;
    }

    /**
     * @return int
     */
    public function getViewMode(): int
    {
        return $this->viewMode;
    }

    /**
     * @param int $viewMode
     * @return Preferences
     */
    public function setViewMode(int $viewMode): Preferences
    {
        $this->viewMode = $viewMode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideUsernames(): bool
    {
        return $this->hideUsernames;
    }

    /**
     * @param bool $hideUsernames
     * @return Preferences
     */
    public function setHideUsernames(bool $hideUsernames): Preferences
    {
        $this->hideUsernames = $hideUsernames;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideRoles(): bool
    {
        return $this->hideRoles;
    }

    /**
     * @param bool $hideRoles
     * @return Preferences
     */
    public function setHideRoles(bool $hideRoles): Preferences
    {
        $this->hideRoles = $hideRoles;
        return $this;
    }

    /**
     * @return bool
     */
    public function isHideAvatars(): bool
    {
        return $this->hideAvatars;
    }

    /**
     * @param bool $hideAvatars
     * @return Preferences
     */
    public function setHideAvatars(bool $hideAvatars): Preferences
    {
        $this->hideAvatars = $hideAvatars;
        return $this;
    }

    /**
     * @return string
     */
    public function getSendOnEnter(): string
    {
        return $this->sendOnEnter;
    }

    /**
     * @param string $sendOnEnter
     * @return Preferences
     */
    public function setSendOnEnter(string $sendOnEnter): Preferences
    {
        $this->sendOnEnter = $sendOnEnter;
        return $this;
    }

    /**
     * @return bool
     */
    public function isRoomCounterSidebar(): bool
    {
        return $this->roomCounterSidebar;
    }

    /**
     * @param bool $roomCounterSidebar
     * @return Preferences
     */
    public function setRoomCounterSidebar(bool $roomCounterSidebar): Preferences
    {
        $this->roomCounterSidebar = $roomCounterSidebar;
        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @param string $language
     * @return Preferences
     */
    public function setLanguage(string $language): Preferences
    {
        $this->language = $language;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarShowFavorites(): bool
    {
        return $this->sidebarShowFavorites;
    }

    /**
     * @param bool $sidebarShowFavorites
     * @return Preferences
     */
    public function setSidebarShowFavorites(bool $sidebarShowFavorites): Preferences
    {
        $this->sidebarShowFavorites = $sidebarShowFavorites;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarShowUnread(): bool
    {
        return $this->sidebarShowUnread;
    }

    /**
     * @param bool $sidebarShowUnread
     * @return Preferences
     */
    public function setSidebarShowUnread(bool $sidebarShowUnread): Preferences
    {
        $this->sidebarShowUnread = $sidebarShowUnread;
        return $this;
    }

    /**
     * @return string
     */
    public function getSidebarSortby(): string
    {
        return $this->sidebarSortby;
    }

    /**
     * @param string $sidebarSortby
     * @return Preferences
     */
    public function setSidebarSortby(string $sidebarSortby): Preferences
    {
        $this->sidebarSortby = $sidebarSortby;
        return $this;
    }

    /**
     * @return string
     */
    public function getSidebarViewMode(): string
    {
        return $this->sidebarViewMode;
    }

    /**
     * @param string $sidebarViewMode
     * @return Preferences
     */
    public function setSidebarViewMode(string $sidebarViewMode): Preferences
    {
        $this->sidebarViewMode = $sidebarViewMode;
        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarHideAvatar(): bool
    {
        return $this->sidebarHideAvatar;
    }

    /**
     * @param bool $sidebarHideAvatar
     * @return Preferences
     */
    public function setSidebarHideAvatar(bool $sidebarHideAvatar): Preferences
    {
        $this->sidebarHideAvatar = $sidebarHideAvatar;
        return $this;
    }

    /**
     * @return bool
     */
    public function isGroupByType(): bool
    {
        return $this->groupByType;
    }

    /**
     * @param bool $groupByType
     * @return Preferences
     */
    public function setGroupByType(bool $groupByType): Preferences
    {
        $this->groupByType = $groupByType;
        return $this;
    }

    /**
     * @return bool
     */
    public function isMuteFocusedConversations(): bool
    {
        return $this->muteFocusedConversations;
    }

    /**
     * @param bool $muteFocusedConversations
     * @return Preferences
     */
    public function setMuteFocusedConversations(bool $muteFocusedConversations): Preferences
    {
        $this->muteFocusedConversations = $muteFocusedConversations;
        return $this;
    }


}
