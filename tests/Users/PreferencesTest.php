<?php

namespace Users;

use AspectMock\Test as test;
use ATDev\RocketChat\Users\Preferences;
use PHPUnit\Framework\TestCase;

class PreferencesTest extends TestCase
{
    public function testJsonSerialize()
    {
        $preferences = new Preferences();
        $preferences->setHideUsernames(false);
        $preferences->setHideRoles(true);
        $preferences->setHideAvatars(null);
        $preferences->setSendOnEnter('test message');
        $preferences->setRoomCounterSidebar(false);
        $preferences->setLanguage(null);
        $preferences->setHighlights(['highlight1', 'testHighlight2']);

        $this->assertSame([
            "highlights" => ['highlight1', 'testHighlight2'],
            "hideUsernames" => false,
            "hideRoles" => true,
            "sendOnEnter" => "test message",
            "roomCounterSidebar" => false
        ], $preferences->jsonSerialize());
    }

    public function testUpdateOutOfResponse1()
    {
        $preferences1 = new PreferencesResponseFixture1();
        $mock = $this->getMockBuilder(Preferences::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($preferences1);

        $this->assertSame('notification', $mock->getNewRoomNotification());
        $this->assertSame('message notification', $mock->getNewMessageNotification());
        $this->assertSame(true, $mock->isUseEmojis());
        $this->assertSame(false, $mock->isConvertAsciiEmoji());
        $this->assertSame(false, $mock->isSaveMobileBandwidth());
        $this->assertSame(true, $mock->isCollapseMediaByDefault());
        $this->assertSame(false, $mock->isAutoImageLoad());
        $this->assertSame('notification', $mock->getEmailNotificationMode());
        $this->assertSame('exhibition', $mock->getRoomsListExhibitionMode());
        $this->assertSame(true, $mock->isUnreadAlert());
        $this->assertSame(50, $mock->getNotificationsSoundVolume());
        $this->assertSame('desktop notifications', $mock->getDesktopNotifications());
        $this->assertSame('mobile notifications', $mock->getMobileNotifications());
        $this->assertSame(false, $mock->isEnableAutoAway());
        $this->assertSame(['test highlight'], $mock->getHighlights());
        $this->assertSame(100, $mock->getDesktopNotificationDuration());
        $this->assertSame(false, $mock->isDesktopNotificationRequireInteraction());
        $this->assertSame(0, $mock->getViewMode());
        $this->assertSame(false, $mock->isHideUsernames());
        $this->assertSame(false, $mock->isHideRoles());
        $this->assertSame(false, $mock->isHideAvatars());
        $this->assertSame('message', $mock->getSendOnEnter());
        $this->assertSame(false, $mock->isRoomCounterSidebar());
        $this->assertSame('pt-BR', $mock->getLanguage());
    }

    public function testUpdateOutOfResponse2()
    {
        $preferences2 = new PreferencesResponseFixture2();
        $mock = $this->getMockBuilder(Preferences::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($preferences2);

        $this->assertSame(false, $mock->isSidebarShowFavorites());
        $this->assertSame(true, $mock->isSidebarShowUnread());
        $this->assertSame('sort ', $mock->getSidebarSortby());
        $this->assertSame('view mode', $mock->getSidebarViewMode());
        $this->assertSame(false, $mock->isSidebarHideAvatar());
        $this->assertSame(true, $mock->isGroupByType());
        $this->assertSame(true, $mock->isMuteFocusedConversations());
    }

    public function testUpdateOutOfResponseFull()
    {
        $preferencesFull = new PreferencesResponseFixtureFull();
        $mock = $this->getMockBuilder(Preferences::class)->enableProxyingToOriginalMethods()->getMock();
        $mock->updateOutOfResponse($preferencesFull);

        $this->assertSame('notification', $mock->getNewRoomNotification());
        $this->assertSame('message notification', $mock->getNewMessageNotification());
        $this->assertSame(true, $mock->isUseEmojis());
        $this->assertSame(false, $mock->isConvertAsciiEmoji());
        $this->assertSame(false, $mock->isSaveMobileBandwidth());
        $this->assertSame(true, $mock->isCollapseMediaByDefault());
        $this->assertSame(false, $mock->isAutoImageLoad());
        $this->assertSame('notification', $mock->getEmailNotificationMode());
        $this->assertSame('exhibition', $mock->getRoomsListExhibitionMode());
        $this->assertSame(true, $mock->isUnreadAlert());
        $this->assertSame(50, $mock->getNotificationsSoundVolume());
        $this->assertSame('desktop notifications', $mock->getDesktopNotifications());
        $this->assertSame('mobile notifications', $mock->getMobileNotifications());
        $this->assertSame(false, $mock->isEnableAutoAway());
        $this->assertSame(['test highlight'], $mock->getHighlights());
        $this->assertSame(100, $mock->getDesktopNotificationDuration());
        $this->assertSame(false, $mock->isDesktopNotificationRequireInteraction());
        $this->assertSame(0, $mock->getViewMode());
        $this->assertSame(false, $mock->isHideUsernames());
        $this->assertSame(false, $mock->isHideRoles());
        $this->assertSame(false, $mock->isHideAvatars());
        $this->assertSame('message', $mock->getSendOnEnter());
        $this->assertSame(false, $mock->isRoomCounterSidebar());
        $this->assertSame('pt-BR', $mock->getLanguage());
        $this->assertSame(false, $mock->isSidebarShowFavorites());
        $this->assertSame(true, $mock->isSidebarShowUnread());
        $this->assertSame('sort ', $mock->getSidebarSortby());
        $this->assertSame('view mode', $mock->getSidebarViewMode());
        $this->assertSame(false, $mock->isSidebarHideAvatar());
        $this->assertSame(true, $mock->isGroupByType());
        $this->assertSame(true, $mock->isMuteFocusedConversations());
    }

    protected function tearDown(): void
    {
        test::clean(); // remove all registered test doubles
    }
}
