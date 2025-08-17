# YouTube Clone - Full Stack Application

A fully responsive YouTube clone built with PHP, MySQL, HTML, CSS, and JavaScript.

## Features

- **Responsive Design**: Works seamlessly on desktop, tablet, and mobile devices
- **Video Management**: Upload, view, and manage videos
- **Search Functionality**: Search videos by title and description
- **Category Filtering**: Filter videos by categories
- **User Interface**: Modern, YouTube-like interface
- **Database Integration**: MySQL database for storing videos, users, and metadata
- **AJAX Loading**: Dynamic content loading without page refresh
- **Infinite Scroll**: Load more videos as you scroll

## Technologies Used

- **Frontend**: HTML5, CSS3, JavaScript (ES6+), Bootstrap 5
- **Backend**: PHP 7.4+
- **Database**: MySQL 5.7+
- **Icons**: Font Awesome 6
- **Responsive Framework**: Bootstrap 5

## Installation

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd youtube-clone
   ```

2. **Set up the database**
   - Create a MySQL database named `youtube_clone`
   - Import the SQL file: `config/init.sql`
   - Update database credentials in `config/database.php`

3. **Configure web server**
   - Place the project in your web server directory (htdocs for XAMPP, www for WAMP)
   - Ensure PHP and MySQL are running

4. **Access the application**
   - Open your browser and navigate to `http://localhost/youtube-clone`

## Database Schema

### Tables:
- **users**: User accounts and profiles
- **categories**: Video categories
- **videos**: Video metadata and information
- **comments**: Video comments
- **subscriptions**: User subscriptions
- **watch_history**: User watch history

## API Endpoints

- `GET /api/videos.php` - Get all videos
- `GET /api/videos.php?action=search&q=query` - Search videos
- `GET /api/videos.php?action=category&category_id=1` - Get videos by category
- `GET /api/videos.php?action=trending` - Get trending videos
- `POST /api/videos.php?action=upload` - Upload new video
- `POST /api/videos.php?action=view` - Increment video views

## File Structure

```
youtube-clone/
├── api/
│   └── videos.php          # API endpoints
├── assets/
│   ├── css/
│   │   └── style.css       # Main stylesheet
│   └── js/
│       └── main.js         # JavaScript functionality
├── config/
│   ├── database.php        # Database connection
│   └── init.sql           # Database schema
├── includes/
│   ├── header.php         # Header component
│   ├── sidebar.php        # Sidebar component
│   └── category-filter.php # Category filter
├── index.php              # Main page
└── README.md             # This file
```

## Features in Detail

### Responsive Design
- Mobile-first approach
- Flexible grid system
- Touch-friendly interface
- Optimized for all screen sizes

### Video Management
- Upload videos with metadata
- Automatic thumbnail generation
- View count tracking
- Category organization

### Search & Filter
- Real-time search functionality
- Category-based filtering
- Trending videos section
- Infinite scroll loading

### User Interface
- Modern, clean design
- Smooth animations and transitions
- Intuitive navigation
- Accessibility features

## Browser Support

- Chrome 60+
- Firefox 55+
- Safari 12+
- Edge 79+

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Test thoroughly
5. Submit a pull request

## License

This project is open source and available under the [MIT License](LICENSE).

## Support

For support and questions, please open an issue in the repository.