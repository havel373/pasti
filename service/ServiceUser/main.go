package main

import (
	"github.com/gin-gonic/gin"
	"github.com/rickyananda1/golang_gin_gorm_JWT/config"
	"github.com/rickyananda1/golang_gin_gorm_JWT/controller"
	"github.com/rickyananda1/golang_gin_gorm_JWT/middleware"
	"github.com/rickyananda1/golang_gin_gorm_JWT/repository"
	"github.com/rickyananda1/golang_gin_gorm_JWT/service"

	"gorm.io/gorm"
)

var (
	db             *gorm.DB                  = config.SetupDatabaseConnection()
	userRepository repository.UserRepository = repository.NewUserRepository(db)
	jwtService     service.JWTService        = service.NewJWTService()
	userService    service.UserService       = service.NewUserService(userRepository)
	authService    service.AuthService       = service.NewAuthService(userRepository)
	authController controller.AuthController = controller.NewAuthController(authService, jwtService)
	userController controller.UserController = controller.NewUserController(userService, jwtService)
)

func main() {
	defer config.CloseDatabaseConnection(db)
	r := gin.Default()

	authRoutes := r.Group("api/auth")
	{
		authRoutes.POST("/login", authController.Login)
		authRoutes.POST("/register", authController.Register)

	}
	dataRoutes := r.Group("api")
	{
		dataRoutes.GET("/all", userController.All)
	}

	userRoutes := r.Group("api/user", middleware.AuthorizeJWT(jwtService))
	{
		userRoutes.GET("/profile", userController.Profile)
		userRoutes.PUT("/profile", userController.Update)
	}

	err := r.Run("127.0.0.1:8002")
	if err != nil {
		return
	}

	r.Run()
}
