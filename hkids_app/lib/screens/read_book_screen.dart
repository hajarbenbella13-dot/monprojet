import 'package:flutter/material.dart';
import 'package:confetti/confetti.dart';
import 'dart:math';

class ReadBookScreen extends StatefulWidget {
  final Map<String, dynamic> book;

  const ReadBookScreen({super.key, required this.book});

  @override
  State<ReadBookScreen> createState() => _ReadBookScreenState();
}

class _ReadBookScreenState extends State<ReadBookScreen> {
  late ConfettiController _confettiController;

  late List<String> pages;
  late int totalPages;

  int currentPage = 1;
  bool isPlaying = false;

  @override
  void initState() {
    super.initState();

    // 📖 Pages dynamiques (تقدر تبدلهم لكل كتاب من بعد)
    pages = [
      "Il était une fois un petit lion courageux... 🦁",
      "Il marchait dans une grande forêt magique... 🌳",
      "Il cherchait sa maman avec espoir... 💛",
      "Il entendit une voix douce derrière lui... 🌟",
      "Enfin, il retrouva sa maman et ils étaient heureux! ❤️",
    ];

    totalPages = pages.length;

    _confettiController = ConfettiController(
      duration: const Duration(seconds: 3),
    );
  }

  @override
  void dispose() {
    _confettiController.dispose();
    super.dispose();
  }

  void _finishStory() {
    _confettiController.play();

    showDialog(
      context: context,
      barrierDismissible: false,
      builder: (_) => _buildFinishDialog(),
    );
  }

  @override
  Widget build(BuildContext context) {
    final Color bookColor = (widget.book['color'] as Color?) ?? Colors.indigo;

    return Scaffold(
      backgroundColor: const Color(0xFF0F172A),
      body: Stack(
        children: [
          /// 🌈 Background plein écran
          Positioned.fill(
            child: Container(
              color: bookColor.withOpacity(0.08),
              child: Center(
                child: Opacity(
                  opacity: 0.25,
                  child: Text(
                    widget.book['emoji'] ?? "📖",
                    style: const TextStyle(fontSize: 320),
                  ),
                ),
              ),
            ),
          ),

          /// ❌ Exit
          Positioned(
            top: 55,
            left: 20,
            child: IconButton(
              icon: const Icon(
                Icons.close_rounded,
                color: Colors.white70,
                size: 32,
              ),
              onPressed: () => Navigator.pop(context),
            ),
          ),

          /// 🔊 Audio Button
          Positioned(
            top: 60,
            left: 0,
            right: 0,
            child: Center(child: _buildAudioButton()),
          ),

          /// 📖 Content bas de l'écran
          Align(
            alignment: Alignment.bottomCenter,
            child: Container(
              height: MediaQuery.of(context).size.height * 0.35,
              padding: const EdgeInsets.symmetric(horizontal: 30),
              decoration: BoxDecoration(
                gradient: LinearGradient(
                  begin: Alignment.topCenter,
                  end: Alignment.bottomCenter,
                  colors: [
                    Colors.transparent,
                    const Color(0xFF0F172A).withOpacity(0.9),
                    const Color(0xFF0F172A),
                  ],
                ),
              ),
              child: Column(
                mainAxisAlignment: MainAxisAlignment.end,
                children: [
                  _buildStoryContent(),
                  const SizedBox(height: 25),
                  _buildPageIndicator(),
                  const SizedBox(height: 35),
                ],
              ),
            ),
          ),

          /// ⬅️ Left Arrow
          if (currentPage > 1)
            Align(
              alignment: Alignment.centerLeft,
              child: _sideArrow(Icons.arrow_back_ios_new_rounded, () {
                setState(() {
                  if (currentPage > 1) {
                    currentPage--;
                  }
                });
              }),
            ),

          /// ➡️ Right Arrow / Terminer
          Align(
            alignment: Alignment.centerRight,
            child: _sideArrow(
              currentPage == totalPages
                  ? Icons.stars_rounded
                  : Icons.arrow_forward_ios_rounded,
              () {
                if (currentPage >= totalPages) {
                  _finishStory();
                } else {
                  setState(() {
                    currentPage++;
                  });
                }
              },
              isGold: currentPage == totalPages,
            ),
          ),

          /// 🎉 Confetti
          Align(
            alignment: Alignment.topCenter,
            child: ConfettiWidget(
              confettiController: _confettiController,
              blastDirection: pi / 2,
              emissionFrequency: 0.05,
              numberOfParticles: 20,
              gravity: 0.3,
              colors: const [
                Colors.amber,
                Colors.blue,
                Colors.pink,
                Colors.green,
              ],
            ),
          ),
        ],
      ),
    );
  }

  /// 🔊 Audio
  Widget _buildAudioButton() {
    return GestureDetector(
      onTap: () {
        setState(() => isPlaying = !isPlaying);
      },
      child: AnimatedContainer(
        duration: const Duration(milliseconds: 300),
        padding: const EdgeInsets.all(14),
        decoration: BoxDecoration(
          shape: BoxShape.circle,
          color: isPlaying ? Colors.blueAccent : Colors.white.withOpacity(0.1),
        ),
        child: Icon(
          isPlaying ? Icons.pause_rounded : Icons.volume_up_rounded,
          size: 30,
          color: isPlaying ? Colors.white : Colors.blueAccent,
        ),
      ),
    );
  }

  /// 📖 Story Text
  Widget _buildStoryContent() {
    int safeIndex = (currentPage - 1).clamp(0, pages.length - 1);

    return Text(
      pages[safeIndex],
      textAlign: TextAlign.center,
      style: const TextStyle(
        fontSize: 22,
        fontWeight: FontWeight.w600,
        color: Colors.white,
        height: 1.6,
      ),
    );
  }

  /// 🔢 Page Indicator
  Widget _buildPageIndicator() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 20, vertical: 8),
      decoration: BoxDecoration(
        color: Colors.white.withOpacity(0.05),
        borderRadius: BorderRadius.circular(20),
      ),
      child: Text(
        "$currentPage / $totalPages",
        style: const TextStyle(
          color: Colors.white60,
          fontWeight: FontWeight.bold,
        ),
      ),
    );
  }

  /// ⬅️➡️ Arrow Widget
  Widget _sideArrow(IconData icon, VoidCallback onTap, {bool isGold = false}) {
    return IconButton(
      onPressed: onTap,
      iconSize: 45,
      icon: Icon(icon, color: isGold ? Colors.amber : Colors.white24),
    );
  }

  /// 🏆 Finish Dialog
  Widget _buildFinishDialog() {
    return Dialog(
      backgroundColor: Colors.transparent,
      insetPadding: const EdgeInsets.symmetric(horizontal: 30),
      child: Stack(
        clipBehavior:
            Clip.none, // Bach l-confetti i-qder i-khrej 3la l-itār dyal l-alert
        alignment: Alignment.center,
        children: [
          /// 1. L-itār dyal l-Alert l-assassi
          Container(
            padding: const EdgeInsets.symmetric(horizontal: 30, vertical: 40),
            decoration: BoxDecoration(
              color: const Color(0xFF1E293B),
              borderRadius: BorderRadius.circular(30),
              boxShadow: [
                BoxShadow(
                  color: Colors.black.withOpacity(0.5),
                  blurRadius: 20,
                  offset: const Offset(0, 10),
                ),
              ],
            ),
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                const Text("🏆", style: TextStyle(fontSize: 80)),
                const SizedBox(height: 20),
                const Text(
                  "Bravo !",
                  style: TextStyle(
                    fontSize: 26,
                    fontWeight: FontWeight.bold,
                    color: Colors.white,
                  ),
                ),
                const SizedBox(height: 10),
                const Text(
                  "Tu as terminé l'histoire 🎉",
                  textAlign: TextAlign.center,
                  style: TextStyle(color: Colors.white70, fontSize: 16),
                ),
                const SizedBox(height: 35),
                SizedBox(
                  width: double.infinity,
                  child: ElevatedButton(
                    style: ElevatedButton.styleFrom(
                      backgroundColor: Colors.blueAccent,
                      padding: const EdgeInsets.symmetric(vertical: 16),
                      shape: RoundedRectangleBorder(
                        borderRadius: BorderRadius.circular(15),
                      ),
                    ),
                    onPressed: () {
                      _confettiController
                          .stop(); // ⚠️ Darori n-7ebssoh 9bel l-khrouj
                      Navigator.of(context).pop();
                      Navigator.of(context).pop();
                    },
                    child: const Text(
                      "RETOUR",
                      style: TextStyle(
                        fontSize: 16,
                        fontWeight: FontWeight.bold,
                        color: Colors.white,
                      ),
                    ),
                  ),
                ),
              ],
            ),
          ),

          /// 2. L-Confetti foq kollchi
          Positioned(
            top: -20, // Bach i-bda i-tla7 chwiya men l-foq
            child: ConfettiWidget(
              confettiController: _confettiController,
              blastDirectionality:
                  BlastDirectionality.explosive, // Explosion f ga3 l-itijahat
              shouldLoop: true, // I-bqa k-i-tla7 7ta t-cliqui Retour
              colors: const [
                Colors.amber,
                Colors.blue,
                Colors.pink,
                Colors.orange,
                Colors.purple,
              ],
              minimumSize: const Size(10, 10),
              maximumSize: const Size(20, 20),
              numberOfParticles: 20,
              gravity: 0.2,
            ),
          ),
        ],
      ),
    );
  }
}
