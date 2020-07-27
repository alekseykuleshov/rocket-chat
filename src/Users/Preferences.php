<?php

namespace ATDev\RocketChat\Users;

class Preferences implements \JsonSerializable
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

    /**
     * Updates current user preferences from response object
     *
     * @param \stdClass $response
     * @return $this
     */
    public function updateOutOfResponse($response)
    {
        if (isset($response->newRoomNotification)) {
            $this->setNewRoomNotification($response->newRoomNotification);
        }
        if (isset($response->newMessageNotification)) {
            $this->setNewMessageNotification($response->newMessageNotification);
        }
        if (isset($response->useEmojis)) {
            $this->setUseEmojis($response->useEmojis);
        }
        if (isset($response->convertAsciiEmoji)) {
            $this->setConvertAsciiEmoji($response->convertAsciiEmoji);
        }
        if (isset($response->saveMobileBandwidth)) {
            $this->setSaveMobileBandwidth($response->saveMobileBandwidth);
        }
        if (isset($response->collapseMediaByDefault)) {
            $this->setCollapseMediaByDefault($response->collapseMediaByDefault);
        }
        if (isset($response->autoImageLoad)) {
            $this->setAutoImageLoad($response->autoImageLoad);
        }
        if (isset($response->emailNotificationMode)) {
            $this->setEmailNotificationMode($response->emailNotificationMode);
        }
        if (isset($response->roomsListExhibitionMode)) {
            $this->setRoomsListExhibitionMode($response->roomsListExhibitionMode);
        }
        if (isset($response->unreadAlert)) {
            $this->setUnreadAlert($response->unreadAlert);
        }
        if (isset($response->notificationsSoundVolume)) {
            $this->setNotificationsSoundVolume($response->notificationsSoundVolume);
        }
        if (isset($response->desktopNotifications)) {
            $this->setDesktopNotifications($response->desktopNotifications);
        }
        if (isset($response->mobileNotifications)) {
            $this->setMobileNotifications($response->mobileNotifications);
        }
        if (isset($response->enableAutoAway)) {
            $this->setEnableAutoAway($response->enableAutoAway);
        }
        if (isset($response->highlights)) {
            $this->setHighlights($response->highlights);
        }
        if (isset($response->desktopNotificationDuration)) {
            $this->setDesktopNotificationDuration($response->desktopNotificationDuration);
        }
        if (isset($response->desktopNotificationRequireInteraction)) {
            $this->setDesktopNotificationRequireInteraction($response->desktopNotificationRequireInteraction);
        }
        if (isset($response->viewMode)) {
            $this->setViewMode($response->viewMode);
        }
        if (isset($response->hideUsernames)) {
            $this->setHideUsernames($response->hideUsernames);
        }
        if (isset($response->hideRoles)) {
            $this->setHideRoles($response->hideRoles);
        }
        if (isset($response->hideAvatars)) {
            $this->setHideAvatars($response->hideAvatars);
        }
        if (isset($response->sendOnEnter)) {
            $this->setSendOnEnter($response->sendOnEnter);
        }
        if (isset($response->roomCounterSidebar)) {
            $this->setRoomCounterSidebar($response->roomCounterSidebar);
        }
        if (isset($response->language)) {
            $this->setLanguage($response->language);
        }
        if (isset($response->sidebarShowFavorites)) {
            $this->setSidebarShowFavorites($response->sidebarShowFavorites);
        }
        if (isset($response->sidebarShowUnread)) {
            $this->setSidebarShowUnread($response->sidebarShowUnread);
        }
        if (isset($response->sidebarSortby)) {
            $this->setSidebarSortby($response->sidebarSortby);
        }
        if (isset($response->sidebarViewMode)) {
            $this->setSidebarViewMode($response->sidebarViewMode);
        }
        if (isset($response->sidebarHideAvatar)) {
            $this->setSidebarHideAvatar($response->sidebarHideAvatar);
        }
        if (isset($response->groupByType)) {
            $this->setGroupByType($response->groupByType);
        }
        if (isset($response->muteFocusedConversations)) {
            $this->setMuteFocusedConversations($response->muteFocusedConversations);
        }

        return $this;
    }

    /**
     * Returns preferences data to submit to api
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_filter(get_object_vars($this), function ($v) { return !is_null($v); });
    }

    /**
     * @return string
     */
    public function getNewRoomNotification()
    {
        return $this->newRoomNotification;
    }

    /**
     * @param string $newRoomNotification
     * @return Preferences
     */
    public function setNewRoomNotification($newRoomNotification)
    {
        if (is_string($newRoomNotification)) {
            $this->newRoomNotification = $newRoomNotification;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getNewMessageNotification()
    {
        return $this->newMessageNotification;
    }

    /**
     * @param string $newMessageNotification
     * @return Preferences
     */
    public function setNewMessageNotification($newMessageNotification)
    {
        if (is_string($newMessageNotification)) {
            $this->newMessageNotification = $newMessageNotification;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isUseEmojis()
    {
        return $this->useEmojis;
    }

    /**
     * @param bool $useEmojis
     * @return Preferences
     */
    public function setUseEmojis($useEmojis)
    {
        if (is_bool($useEmojis)) {
            $this->useEmojis = $useEmojis;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isConvertAsciiEmoji()
    {
        return $this->convertAsciiEmoji;
    }

    /**
     * @param bool $convertAsciiEmoji
     * @return Preferences
     */
    public function setConvertAsciiEmoji($convertAsciiEmoji)
    {
        if (is_bool($convertAsciiEmoji)) {
            $this->convertAsciiEmoji = $convertAsciiEmoji;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function isSaveMobileBandwidth()
    {
        return $this->saveMobileBandwidth;
    }

    /**
     * @param bool $saveMobileBandwidth
     * @return Preferences
     */
    public function setSaveMobileBandwidth($saveMobileBandwidth)
    {
        if (is_bool($saveMobileBandwidth)) {
            $this->saveMobileBandwidth = $saveMobileBandwidth;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isCollapseMediaByDefault()
    {
        return $this->collapseMediaByDefault;
    }

    /**
     * @param bool $collapseMedia
     * @return Preferences
     */
    public function setCollapseMediaByDefault($collapseMedia)
    {
        if (is_bool($collapseMedia)) {
            $this->collapseMediaByDefault = $collapseMedia;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoImageLoad()
    {
        return $this->autoImageLoad;
    }

    /**
     * @param bool $autoLoad
     * @return Preferences
     */
    public function setAutoImageLoad($autoLoad)
    {
        if (is_bool($autoLoad)) {
            $this->autoImageLoad = $autoLoad;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getEmailNotificationMode()
    {
        return $this->emailNotificationMode;
    }

    /**
     * @param string $mode
     * @return Preferences
     */
    public function setEmailNotificationMode($mode)
    {
        if (is_string($mode)) {
            $this->emailNotificationMode = $mode;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getRoomsListExhibitionMode()
    {
        return $this->roomsListExhibitionMode;
    }

    /**
     * @param string $mode
     * @return Preferences
     */
    public function setRoomsListExhibitionMode($mode)
    {
        if (is_string($mode)) {
            $this->roomsListExhibitionMode = $mode;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isUnreadAlert()
    {
        return $this->unreadAlert;
    }

    /**
     * @param bool $unreadAlert
     * @return Preferences
     */
    public function setUnreadAlert($unreadAlert)
    {
        if (is_bool($unreadAlert)) {
            $this->unreadAlert = $unreadAlert;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getNotificationsSoundVolume()
    {
        return $this->notificationsSoundVolume;
    }

    /**
     * @param int $volume
     * @return Preferences
     */
    public function setNotificationsSoundVolume($volume)
    {
        if (is_int($volume)) {
            $this->notificationsSoundVolume = $volume;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getDesktopNotifications()
    {
        return $this->desktopNotifications;
    }

    /**
     * @param string $desktopNotifications
     * @return Preferences
     */
    public function setDesktopNotifications($desktopNotifications)
    {
        if (is_string($desktopNotifications)) {
            $this->desktopNotifications = $desktopNotifications;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getMobileNotifications()
    {
        return $this->mobileNotifications;
    }

    /**
     * @param string $mobileNotifications
     * @return Preferences
     */
    public function setMobileNotifications($mobileNotifications)
    {
        if (is_string($mobileNotifications)) {
            $this->mobileNotifications = $mobileNotifications;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnableAutoAway()
    {
        return $this->enableAutoAway;
    }

    /**
     * @param bool $enableAutoAway
     * @return Preferences
     */
    public function setEnableAutoAway($enableAutoAway)
    {
        if (is_bool($enableAutoAway)) {
            $this->enableAutoAway = $enableAutoAway;
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHighlights()
    {
        return $this->highlights;
    }

    /**
     * @param array $highlights
     * @return Preferences
     */
    public function setHighlights($highlights)
    {
        if (is_array($highlights)) {
            $this->highlights = $highlights;
        }

        return $this;
    }

    /**
     * @return int
     */
    public function getDesktopNotificationDuration()
    {
        return $this->desktopNotificationDuration;
    }

    /**
     * @param int $duration
     * @return Preferences
     */
    public function setDesktopNotificationDuration($duration)
    {
        if (is_int($duration)) {
            $this->desktopNotificationDuration = $duration;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isDesktopNotificationRequireInteraction()
    {
        return $this->desktopNotificationRequireInteraction;
    }

    /**
     * @param bool $require
     * @return Preferences
     */
    public function setDesktopNotificationRequireInteraction($require)
    {
        if (is_bool($require)) {
            $this->desktopNotificationRequireInteraction = $require;
        }
        return $this;
    }

    /**
     * @return int
     */
    public function getViewMode()
    {
        return $this->viewMode;
    }

    /**
     * @param int $viewMode
     * @return Preferences
     */
    public function setViewMode($viewMode)
    {
        if (is_int($viewMode)) {
            $this->viewMode = $viewMode;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideUsernames()
    {
        return $this->hideUsernames;
    }

    /**
     * @param bool $hideUsernames
     * @return Preferences
     */
    public function setHideUsernames($hideUsernames)
    {
        if (is_bool($hideUsernames)) {
            $this->hideUsernames = $hideUsernames;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideRoles()
    {
        return $this->hideRoles;
    }

    /**
     * @param bool $hideRoles
     * @return Preferences
     */
    public function setHideRoles($hideRoles)
    {
        if (is_bool($hideRoles)) {
            $this->hideRoles = $hideRoles;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isHideAvatars()
    {
        return $this->hideAvatars;
    }

    /**
     * @param bool $hideAvatars
     * @return Preferences
     */
    public function setHideAvatars($hideAvatars)
    {
        if (is_bool($hideAvatars)) {
            $this->hideAvatars = $hideAvatars;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSendOnEnter()
    {
        return $this->sendOnEnter;
    }

    /**
     * @param string $sendOnEnter
     * @return Preferences
     */
    public function setSendOnEnter($sendOnEnter)
    {
        if (is_string($sendOnEnter)) {
            $this->sendOnEnter = $sendOnEnter;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isRoomCounterSidebar()
    {
        return $this->roomCounterSidebar;
    }

    /**
     * @param bool $show
     * @return Preferences
     */
    public function setRoomCounterSidebar($show)
    {
        if (is_bool($show)) {
            $this->roomCounterSidebar = $show;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Language
     *
     * @param string $language 'pt-BR'
     * @return Preferences
     */
    public function setLanguage($language)
    {
        if (is_string($language)) {
            $this->language = $language;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarShowFavorites()
    {
        return $this->sidebarShowFavorites;
    }

    /**
     * @param bool $show
     * @return Preferences
     */
    public function setSidebarShowFavorites($show)
    {
        if (is_bool($show)) {
            $this->sidebarShowFavorites = $show;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarShowUnread()
    {
        return $this->sidebarShowUnread;
    }

    /**
     * @param bool $show
     * @return Preferences
     */
    public function setSidebarShowUnread($show)
    {
        if (is_bool($show)) {
            $this->sidebarShowUnread = $show;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSidebarSortby()
    {
        return $this->sidebarSortby;
    }

    /**
     * @param string $sortBy
     * @return Preferences
     */
    public function setSidebarSortby($sortBy)
    {
        if (is_string($sortBy)) {
            $this->sidebarSortby = $sortBy;
        }

        return $this;
    }

    /**
     * @return string
     */
    public function getSidebarViewMode()
    {
        return $this->sidebarViewMode;
    }

    /**
     * @param string $sidebarViewMode
     * @return Preferences
     */
    public function setSidebarViewMode($sidebarViewMode)
    {
        if (is_string($sidebarViewMode)) {
            $this->sidebarViewMode = $sidebarViewMode;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isSidebarHideAvatar()
    {
        return $this->sidebarHideAvatar;
    }

    /**
     * @param bool $hide
     * @return Preferences
     */
    public function setSidebarHideAvatar($hide)
    {
        if (is_bool($hide)) {
            $this->sidebarHideAvatar = $hide;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isGroupByType()
    {
        return $this->groupByType;
    }

    /**
     * @param bool $groupByType
     * @return Preferences
     */
    public function setGroupByType($groupByType)
    {
        if (is_bool($groupByType)) {
            $this->groupByType = $groupByType;
        }

        return $this;
    }

    /**
     * @return bool
     */
    public function isMuteFocusedConversations()
    {
        return $this->muteFocusedConversations;
    }

    /**
     * @param bool $mute
     * @return Preferences
     */
    public function setMuteFocusedConversations($mute)
    {
        if (is_bool($mute)) {
            $this->muteFocusedConversations = $mute;
        }

        return $this;
    }
}
