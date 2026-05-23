using System;
using System.Collections.Generic;
using System.Text.RegularExpressions;

public class User : Person
{
    public enum Permission
    {
        AllAccess = -1,
        ShowAll = 1,
        Add = 2,
        Delete = 4,
        Update = 8,
        Find = 16
    }

    public enum Mode
    {
        Empty = 0,
        Update = 1,
        Add = 2
    }

    public enum OperationResult
    {
        Fail = 0,
        Success = 1,
        EmailExists = 2,
        Updated = 3,
        Deleted = 4,
        FailEmptyObject = 5,
        NoPermissions = 6
    }

    public enum UserInputError
    {
        MissingUsername = 1,
        LengthUsername = 2,
        InvalidUsername = 3,
        MissingPassword = 4,
        LengthPassword = 5,
        MissingImage = 6,
        MissingBackgroundImage = 7,
        MissingToken = 8,
        InvalidEmail = 9,
        NoErrors = 10
    }

    private string _backgroundImage;
    private Mode _mode;
    private int _permission;

    public string BackgroundImage => _backgroundImage;
    public int PermissionValue => _permission;
    public Mode CurrentMode => _mode;

    public User(
        Mode mode,
        int id,
        string username,
        string email,
        string password,
        string role,
        int permission,
        bool active,
        string token,
        DateTime createdAt,
        string image,
        string backgroundImage
    ) : base(id, username, email, password, role, active, token, createdAt, image)
    {
        _mode = mode;
        _permission = permission;
        _backgroundImage = backgroundImage;
    }

    private static bool HasPermission(int userPermission, Permission required)
    {
        if (userPermission == (int)Permission.AllAccess)
            return true;

        return (userPermission & (int)required) == (int)required;
    }

    public static bool CanAdd(int permission) => HasPermission(permission, Permission.Add);

    public static bool CanDelete(int permission)
        => HasPermission(permission, Permission.Delete);

    public static bool CanUpdate(int permission)
        => HasPermission(permission, Permission.Update);

    public static bool CanFind(int permission)
        => HasPermission(permission, Permission.Find);

    public static bool CanShowAll(int permission)
        => HasPermission(permission, Permission.ShowAll);

    public static UserInputError ValidateUsername(string username)
    {
        if (string.IsNullOrEmpty(username))
            return UserInputError.MissingUsername;

        if (username.Length < 3 || username.Length > 30)
            return UserInputError.LengthUsername;

        if (!Regex.IsMatch(username, @"^[a-zA-Z0-9_]{3,30}$"))
            return UserInputError.InvalidUsername;

        return UserInputError.NoErrors;
    }

    public static UserInputError ValidateEmail(string email)
    {
        if (string.IsNullOrEmpty(email))
            return UserInputError.InvalidEmail;

        if (!email.Contains("@"))
            return UserInputError.InvalidEmail;

        return UserInputError.NoErrors;
    }

    public static UserInputError ValidatePassword(string password)
    {
        if (string.IsNullOrEmpty(password))
            return UserInputError.MissingPassword;

        if (password.Length < 10 || password.Length > 15)
            return UserInputError.LengthPassword;

        return UserInputError.NoErrors;
    }
}